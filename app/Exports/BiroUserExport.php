<?php

namespace App\Exports;

use App\Models\Biro;
use App\Models\BiroUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BiroUserExport implements FromCollection, WithMapping, WithHeadings
{
    private $biroUser;
    public function __construct(
        public $gender = null, 
        public $province_code = null, 
        public $city_code = null,
    ){
        $this->biroUser = new BiroUser();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $responseData = new BiroUser();

        if(!empty($gender))
            $responseData = $responseData->where("gender", $gender);
        if(!empty($province_code))
            $responseData = $responseData->where("province_code", $province_code);
        if(!empty($city_code))
            $responseData = $responseData->where("city_code", $city_code);

        $responseData = $responseData->orderBy('id', 'desc')
            ->get();

        return $responseData;
    }

    /**
    * @param BiroUser $biroUser
    */
    public function map($biroUser): array
    {
        return [
            $biroUser->name,
            $biroUser->email,
            $biroUser->phone,
            $biroUser->gender == "M" ? "Laki-laki" : "Perempuan",
            $biroUser->province->nama ?? "",
            $biroUser->city->nama ?? "",
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No HP',
            'jenis kelamin',
            'Provinsi',
            'Kota',
        ];
    }
}
