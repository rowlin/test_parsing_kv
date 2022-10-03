<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\DealTypeEnum;
use App\Models\Estate;
use App\Repositories\EstateRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class KvParseService implements ParseInterface
{
    private $deal_type;
    private $result = [];

    public function __construct()
    {
        $this->deal_type = DealTypeEnum::ALL;
    }

    public function setDeal(DealTypeEnum $data): void
    {
        $this->deal_type = $data;
    }

    public function run(DealTypeEnum $data = DealTypeEnum::ALL): array{
        $this->setDeal($data);
        $this->getData();
        return $this->store();
    }

    public function getData(): array
    {
        $contents = simplexml_load_file('https://www.kv.ee/?act=rss.objectsearch&lang=en&qry=act=search.simple&last_deal_type='. $this->deal_type->value .'&deal_type='.$this->deal_type->value.'&search_type=old');

        foreach ($contents->channel as  $index) {
            foreach ($index->item as $item) {
                $t_data = $item->description->__toString();
                if ($this->getAddress($t_data) !== null) {
                    $data = [
                        'title' => $item->title->__toString(),
                        'deal_type' => $this->getDealType($item->title->__toString())->value,// get from request
                        'address' => $this->getAddress($t_data),  // preg_match('<b>')
                        'image' => $this->getImage($t_data),
                        'url' => $item->link->__toString(),
                        'description_full' => $t_data,
                        'published' => now()
                    ];
                    $extra = $this->getExtra($t_data);
                    $this->result[] = array_merge($data, $extra);
                }
            }
        }
        return $this->result;
    }

    public function getDealType(string $title): DealTypeEnum
    {
        switch($title){
            case (str_contains($title, 'short term rent' ) !== false):
                 $res = DealTypeEnum::SHORT_RENT;
                 break;
            case (str_contains($title, 'rent' ) !== false) :
                $res = DealTypeEnum::RENT;
                break;
            case (str_contains($title, 'sale' ) !== false) :
                $res =  DealTypeEnum::SALE;
                break;
            default :
                $res = DealTypeEnum::SALE;
        }
        return  $res;
    }

    public function getAddress(string $data): string
    {
        preg_match_all( '/<b>(.*?)<\/b>/s', $data, $match );
        return implode(' ',$match[1]) ;
    }

    public function getImage(string $data): string
    {
        preg_match( '/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i' , $data, $match );
        return $match[1] ?? "";
    }

    public function getExtra(string $data): array
    {
        preg_match_all( '/<td(.*?)<\/td>/s', $data, $match );
        $data_ = [
            'description' => '' ,
            'float' => null,
            'float_total'=> null,
            'total_area' => 0,
            'year' => null,
            'price' => null,
            'price_per_m' => null,
        ];
        if(isset($match[1][1])){
            preg_match_all( '/<b>(.*?)<\/b>/s', $match[1][1], $m );
            $cite_length = sizeof($m[1]);
            $sep =  explode(',' , $match[1][1]);

            for( $i = $cite_length , $count = 0 ;  ($i < sizeof($sep))  ; ++$i , ++$count){
                switch( $sep[$i]) {
                    case (str_contains($sep[$i], '/') !== false && $count == 0) :
                        $data_['float'] = trim(explode('/', $sep[$i])[0]);
                        $data_['float_total'] = explode('/', $sep[$i])[1];
                        break;
                    case (str_contains($sep[$i], 'm²') !== false) :
                        $data_['total_area'] = (double) trim(explode('m', trim($sep[$i] . ',' . $sep[++$i]))[0]);
                        break;
                    case (str_contains($sep[$i], 'year') !== false) :
                        preg_match('/\d+/', $sep[$i], $year);
                        $data_['year'] = $year[0] ?? null;
                        break;
                    case(str_contains($sep[$i] , "EUR") !== false) :
                        $price = explode('EUR' , str_replace(' ', '' ,$sep[$i]));
                        if(sizeof($price) > 2){
                            $data_['price'] = (double) trim($price[0]) ?? 0;
                            $data_['price_per_m'] =  (double) trim($price[1]) ?? 0;
                        }
                        break;
                    default :
                        $data_['description'] .= (strlen($data_['description']) > 2 && (substr($data_['description'], -1) != ','))? ',': ' '. trim($sep[$i]) ." ";
                        break;
                }

            }
        }
        return $data_;
    }

    public function store() : array{
        $message = ['message' => "Added ". sizeof($this->result) ." in database." ];
        $service =  new EstateService(new EstateRepository(new Estate()));
        try {
             $service->insert($this->result);
             return $message;
        }catch (\Exception $e){
            throw new HttpResponseException( new Response(['message' , $e->getMessage()] ), 500);
        }
    }
}
