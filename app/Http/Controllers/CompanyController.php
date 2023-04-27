<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyStoreRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Resources\Company\CompanyResourceFull;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getAll()
    {
        return CompanyResourceFull::collection(Company::all());
    }

    public function getById(int $id){
        $company = Company::findOrFail($id);
        return CompanyResourceFull::make($company);

    }

    public function store(CompanyStoreRequest $request)
    {
        $data = $request->validated();
        $email_verif = 0;
        if($data['is_email_verified']===true){
            $email_verif = 1;
        }
        $company = Company::create([
            'title' => $data['title'],
            'email' => $data['email'],
            'is_email_verified' => $email_verif
        ]);
    }


    public function update(CompanyUpdateRequest $request, int $id)
    {

        $data = $request->validated();
        $email_verif = 0;
        if($data['is_email_verified']===true){
            $email_verif = 1;
        }
        $company = Company::findOrFail($id);
        $company->update([
            'title' => $data['title'],
            'email' => $data['email'],
            'is_email_verified' => $email_verif ?? 0
        ]);
    }

    public function destroy(int $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, 204);
    }
}
