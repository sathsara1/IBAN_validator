<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class IbansResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @return array<string, mixed>
         */
        public function toArray(Request $request): array
        {
            return [
                'id' => (string) $this->id,
                'iban' =>  $this->iban,
                'verified_by' => [
                    'id' => (string) $this->user->id,
                    'name' => (string) $this->user->name,
                    'email' => (string) $this->user->email,
                ],
            ];
        }
    }
