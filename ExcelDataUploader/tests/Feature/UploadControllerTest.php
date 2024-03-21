<?php
    
    namespace Tests\Feature;
    
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Queue;
    use Illuminate\Support\Facades\Storage;
    use App\Http\Controllers\UploadController;
    use App\Jobs\ProcessExcelData;
    use Tests\TestCase;
    
    class UploadControllerTest extends TestCase
    {
        use RefreshDatabase;
        
        //todo: test these tests
        
        public function test_upload_success()
        {
            //todo: implement uplaod
        }
        
        public function test_upload_validation_error()
        {
            $response = $this->post('/upload');
            
            $response->assertStatus(422);
            $response->assertJsonValidationErrors('file');
        }
        
        public function test_upload_invalid_file_format()
        {
            $file = UploadedFile::fake()->createWithContent('test.txt', 'Plain text data');
            $response = $this->post('/upload', ['file' => $file]);
            
            $response->assertStatus(422);
            $response->assertJsonValidationErrors('file');
        }
        
        public function test_upload_storage_failure()
        {
            Storage::disk('local')->shouldReceive('put')->once()->andReturn(false);
            
            $file = UploadedFile::fake()->createWithContent('test.xlsx', 'Excel data');
            $response = $this->post('/upload', ['file' => $file]);
            
            $response->assertStatus(500);
            $response->assertJson(['error' => 'Failed to upload file']);
        }
    }
