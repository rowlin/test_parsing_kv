<?php


namespace App\Services;
use App\Http\Requests\EstateRequest;
use App\Models\Estate;
use App\Repositories\EstateRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
class EstateService
{

    public function __construct(private EstateRepository $estateRepository){}

    public function getAll(?EstateRequest $request = null): LengthAwarePaginator | Collection
    {
        if($request)
            return $this->estateRepository->getAllWithPaginate($request);
        else
            return $this->estateRepository->getAll();
    }

    public function getById(int $id) : Estate
    {
        return $this->estateRepository->getById($id);
    }

    public function insert(array $data) : void{
        if($this->getAll()->count() === 0 ) {
            $this->estateRepository->insert($data);
        }else{
            $this->estateRepository->checkAndInsert($data);
        }
    }


}
