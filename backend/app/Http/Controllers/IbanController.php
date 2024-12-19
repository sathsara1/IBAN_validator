<?php

namespace App\Http\Controllers;

use App\Http\Requests\IbanRequest;
use App\Http\Resources\IbansResource;
use App\Models\Iban;
use App\Traits\HttpResponses;
use App\Traits\IbanValidate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IbanController extends Controller
{

    use IbanValidate, HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ibans = Iban::with('user')->get();
        return $this->success(IbansResource::collection($ibans));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IbanRequest $request)
    {
        $ibanInput = strtoupper(str_replace(' ', '', $request->iban)); // Normalize IBAN


        if (!$this->isValidIban($ibanInput)) {
            return $this->error('Invalid IBAN', 400);
        }

        try {
            $iban = new Iban();
            $iban->iban = $ibanInput; // Save the valid IBAN
            $iban->verified_by = $request->user()->id; // Associate the IBAN with the authenticated user
            $iban->save();

            return $this->success(new IbansResource($iban), 'IBAN created successfully!', 201);
        } catch (Exception $e) {
            Log::error('Error saving IBAN: ' . $e->getMessage());

            return $this->error('An error occurred while saving the IBAN. Please try again later.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Iban $ibn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Iban $ibn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Iban $ibn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Iban $ibn)
    {
        //
    }
}
