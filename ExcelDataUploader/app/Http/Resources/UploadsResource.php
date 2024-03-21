<?php
    
    namespace App\Http\Resources;
    
    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;
    
    class UploadsResource extends JsonResource
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
                'attributes' => [
                    'file_name' => $this->file_name,
                    'file_path' => $this->file_path,
                    'file_size' => $this->file_size,
                    'uploaded_at' => $this->created_at->format('Y-m-d H:i:s')
                ],
                'relationships' => [
                    'id' => (string) $this->user->id,
                    'name' => (string) $this->user->name,
                    'email' => (string) $this->user->email,
                ],
            ];
        }
    }
