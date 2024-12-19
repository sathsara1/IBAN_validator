<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\DocumentUploadRequest;
    use App\Http\Resources\UploadsResource;
    use App\Jobs\ProcessExcelData;
    use App\Models\Upload;
    use App\Traits\HttpResponses;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    
    class UploadController extends Controller
    {
        use HttpResponses;
        
        public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
        {
            return UploadsResource::collection(
                Upload::where('uploaded_by', Auth::user()->id)->get()
            );
        }
        
        public function upload(DocumentUploadRequest $request): \Illuminate\Http\JsonResponse
        {
            $uploadedFiles = [];
            
            try {
                if (!$request->hasFile('files')) {
                    throw new Exception('No file uploaded');
                }
                
                foreach ($request->file('files') as $file) {
                    
                    try {
                        
                        $path = Storage::disk('local')->put('uploads', $file);
                        $document = Upload::create([
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_size' => Storage::disk('local')->size($path),
                            'uploaded_by' => Auth::user()->id,
                        ]);
                      
                        if ($document){
                            Log::info("File uploaded successfully: " . $path);
                            
                            ProcessExcelData::dispatch($file->getClientOriginalName(), $path);
                            
                        }else{
                            Log::error("File uploaded failed: " . $path);
                        }

                    } catch (Exception $e) {
                        
                        Log::error("Failed to create upload record: " . $e->getMessage());
                    }
                    
                    $uploadedFiles[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'filename' => $path,
                    ];
                }
            } catch (Exception $e) {
                return $this->error($e->getMessage(), 500);
            }
            
            return $this->success($uploadedFiles, 'File uploaded successfully', 200);
        }
    }
