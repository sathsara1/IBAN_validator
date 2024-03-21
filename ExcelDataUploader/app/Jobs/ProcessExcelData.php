<?php
    
    namespace App\Jobs;
    
    use App\Models\Upload;
    use Exception;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use Maatwebsite\Excel\Facades\Excel;
    use App\Models\UploadDetail;
    
    class ProcessExcelData implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        
        /**
         * The path to the uploaded Excel file.
         *
         * @var string
         */
        protected $filePath;
        
        /**
         * Create a new job instance.
         *
         * @param string $filePath
         *
         * @return void
         */
        public function __construct($file,$filePath)
        {
            $this->filePath = $filePath;
            $this->file = $file;
        }
        
        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(): void
        {
            try {
                $data = Excel::toArray(storage_path('app/' . $this->filePath));
                Log::info("excel data: " . $data);
                dd($data);
                DB::beginTransaction();
                
                UploadDetail::insert($data[0]); // Assuming data starts from the first row
                
                $upload = Upload::where('file_path', $this->filePath)
                                ->where('user_id', Auth::id())
                                ->first();
                
                if ($upload) {
                    $upload->is_excel_processed = true;
                    $upload->save();
                }
                
                DB::commit();
                Log::info("Excel data processed successfully: " . $this->filePath);
                
            } catch (Exception $e) {
                DB::rollBack();
                Log::error("Failed to process Excel data: " . $e->getMessage());
            }
        }
    }
