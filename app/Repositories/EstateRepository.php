<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Http\Requests\EstateRequest;
use App\Models\Estate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator;

class EstateRepository
{
    public function __construct(protected Estate $estate){}

    public function getAllWithPaginate(EstateRequest $request): LengthAwarePaginator
    {
        return  $this->estate
            ->when( $request->has('deal_type') , function (Builder $query) use ($request){
                $query->where('deal_type', $request->get('deal_type'));
            })->when( $request->has('float'), function(Builder $query) use ($request){
                $query->where('float',"LIKE" , $request->get('float') . "%");
            })->when( $request->has('float_total'), function(Builder $query) use ($request){
                $query->where('float_total', "LIKE",$request->get('float_total') . '%');
            })->when( $request->has('address'), function(Builder $query) use ($request){
                $query->where('address', 'LIKE', "%".$request->get('address'). '%');
            })->when($request->has('total_area'), function(Builder $query) use ($request){
                $query->where('total_area', $request->get('float'));
            })->when($request->has('year'), function(Builder $query) use ($request){
                $query->where('year','LIKE' ,$request->get('year'));
            })->when( $request->has('price'), function(Builder $query) use ($request){
                $query->where('price', $request->get('price'));
            })
            ->orderBy('created_at' , "DESC")
            ->select('description_full')
            ->paginate( $request->has('perPage') ? $request->get('perPage') : 15);
    }

    public function getAll(): Collection
    {
        return  $this->estate->all();
    }

    public function getById(int $id) : Estate
    {
        $estate  = $this->estate->whereId($id)->first();
        if(!$estate)
            throw new NotFoundException('Estate not found' , 404);
        else return  $estate;
    }

    public function checkAndInsert(array $data) : void{
        foreach ($data as $d){
            $hasEstate =  $this->estate->where(['url' => $d['url']])->first();
            if(!$hasEstate){
                $this->estate->save($d);
            }
        }
    }

    public function insert(array $data) : void {
        try {
            $this->estate->insert($data);
        }catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => $e->getMessage()], 500));
        }
    }

    public function delete(int $id) : bool
    {
        return $this->getById($id)->delete();
    }

}
