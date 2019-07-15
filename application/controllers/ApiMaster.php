<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/ImplementJwt.php';

class ApiMaster extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('hapus_model');
        $this->objOfJwt = new ImplementJwt();        
    }
    
    public function login() {
        $post = json_decode(file_get_contents("php://input"), true);
        
        $username = $post['username'];
        $password = $post['password'];        
        
        $user = $this->db->get_where('admin', ['username' => $username])->row_array();        
        $passhash = password_hash($user['password'], PASSWORD_DEFAULT); 
        if ($user) {          
            if ($user['is_active'] == 1) {
                if (password_verify($password, $passhash)) {
                    $tokenData['uniqueId'] = $user['id_admin'];
                    $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
                    
                    $jwtToken = $this->objOfJwt->GenerateToken($tokenData);

                    $data = array(
                        'iduser'=>$user['id_admin'],
                        'token'=>$jwtToken,
                        'datein'=>Date('Y-m-d h:i:s'),
                        );
                    $check = $this->db->where(array('iduser'=>$user['id_admin']))->get('api_token');    
                    if( $check->num_rows() > 0 ){
                        $this->db->where(array('iduser'=>$user['id_admin']))->update('api_token',$data);
                    }else{
                        $this->db->insert('api_token',$data);
                    }
                    
                    $response = array(
                        'status' => true,
                        'data' => array(
                            'token'=> $jwtToken,
                            ),
                        'message' => 'Berhasil'
                    );
                
                    $this->output
                      ->set_status_header(200)
                      ->set_content_type('application/json', 'utf-8')
                      ->set_output(json_encode($response, JSON_PRETTY_PRINT))
                      ->_display();
                      exit;
                } else {
                    // pesan password salah dan username salah
                    $response = array(
                        'status' => false,
                        'data' => null,
                        'message' => 'Gagal, Password salah!'
                    );
                
                    $this->output
                      ->set_status_header(200)
                      ->set_content_type('application/json', 'utf-8')
                      ->set_output(json_encode($response, JSON_PRETTY_PRINT))
                      ->_display();
                      exit;
                }
            } else {
                // pesan user belum status aktiv                
                $response = array(
                    'status' => false,
                    'data' => null,
                    'message' => 'Gagal, Akun tersebut belum aktif!'
                );
            
                $this->output
                  ->set_status_header(200)
                  ->set_content_type('application/json', 'utf-8')
                  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
                  ->_display();
                  exit;
            }
        } else {
            // user tidak ditemukan
            $response = array(
                'status' => false,
                'data' => null,
                'message' => 'Gagal, Username tidak ditemukan!'
            );
        
            $this->output
              ->set_status_header(200)
              ->set_content_type('application/json', 'utf-8')
              ->set_output(json_encode($response, JSON_PRETTY_PRINT))
              ->_display();
              exit;
        }
    }

    public function admin() {		
      fuc_checktoken($this->input->request_headers('Authorization'));			

    	$data = $this->db->get("admin");
    	
    	$response = array(
    		'status' => true,
    		'data' => array(
    			'record'=>$data->result(),
    			'totalrecord'=>$data->num_rows(),
    			),
    		'message' => 'Berhasil menampilkan data'
    	);

    	$this->output
    	  ->set_status_header(200)
    	  ->set_content_type('application/json', 'utf-8')
    	  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
    	  ->_display();
    	  exit; 
    }

    public function manga() {					
    	$data = $this->db->join("kategori","manga.id_kategori=kategori.id_kategori","left")->get("manga");
    	
    	$response = array(
    		'status' => true,
    		'data' => array(
    			'record'=>$data->result(),
    			'totalrecord'=>$data->num_rows(),
    			),
    		'message' => 'Berhasil menampilkan data'
    	);

    	$this->output
    	  ->set_status_header(200)
    	  ->set_content_type('application/json', 'utf-8')
    	  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
    	  ->_display();
    	  exit; 
    }	

    public function detail_manga($id) {          
      $data = $this->db->where('id_manga',$id)
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("manga");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function most_viewed() {          
      $data = $this->db->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("manga");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function tampilmostkanan() {          
      $data = $this->db->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->order_by('pengunjung','desc')
                       ->limit('3')
                       ->get("manga");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function latest_release() {         
      $data = $this->db->join("manga","chapter.id_manga=manga.id_manga","left")
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->order_by('chapter.id_chapter','desc')
                       ->get("chapter");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function tampillateskanan() {         
      $data = $this->db->join("manga","chapter.id_manga=manga.id_manga","left")
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->order_by('chapter.id_chapter','desc')
                       ->limit('3')
                       ->get("chapter");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function kategori() {					
    	$data = $this->db->get("kategori");
    	
    	$response = array(
    		'status' => true,
    		'data' => array(
    			'record'=>$data->result(),
    			'totalrecord'=>$data->num_rows(),
    			),
    		'message' => 'Berhasil menampilkan data'
    	);

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }

    public function detail_kategori($id) {          
      $data = $this->db->where('manga.id_kategori',$id)
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("manga");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }		

    public function chapter() {					
    	$data = $this->db->join("manga","chapter.id_manga=manga.id_manga","left")
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("chapter");
    	
    	$response = array(
    		'status' => true,
    		'data' => array(
    			'record'=>$data->result(),
    			'totalrecord'=>$data->num_rows(),
    			),
    		'message' => 'Berhasil menampilkan data'
    	);

    	$this->output
    	  ->set_status_header(200)
    	  ->set_content_type('application/json', 'utf-8')
    	  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
    	  ->_display();
    	  exit; 
    }

    public function detail_chapter($id) {					
    	$data = $this->db->where('chapter.id_chapter',$id)
                       ->join("manga","chapter.id_manga=manga.id_manga","left")
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("chapter");
    	
    	$response = array(
    		'status' => true,
    		'data' => array(
    			'record'=>$data->result(),
    			'totalrecord'=>$data->num_rows(),
    			),
    		'message' => 'Berhasil menampilkan data'
    	);

    	$this->output
    	  ->set_status_header(200)
    	  ->set_content_type('application/json', 'utf-8')
    	  ->set_output(json_encode($response, JSON_PRETTY_PRINT))
    	  ->_display();
    	  exit; 
    }

    public function detail($id) {          
      $data = $this->db->where('chapter.id_chapter',$id)
                       ->join("chapter","detail.id_chapter=chapter.id_chapter","left")
                       ->join("manga","chapter.id_manga=manga.id_manga","left")
                       ->join("kategori","manga.id_kategori=kategori.id_kategori","left")
                       ->get("detail");
      
      $response = array(
        'status' => true,
        'data' => array(
          'record'=>$data->result(),
          'totalrecord'=>$data->num_rows(),
          ),
        'message' => 'Berhasil menampilkan data'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit; 
    }   

    public function tambah_kategori() {
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);
      
      $data = [
          'nama_kategori' => $post['nama_kategori']
      ];
      
      $this->db->insert("kategori",$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil, data berhasil disimpan!'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;      
    }

    public function base64_to_jpeg($base64_string, $output_file) {
      $ifp = fopen( $output_file, 'wb' ); 
      fwrite( $ifp, base64_decode( $base64_string ) );
      fclose( $ifp ); 
  
      return $output_file; 
    }

    public function tambah_manga() {
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);

      $cover = $this->base64_to_jpeg($post['cover'],"images/cover/".date("Y_m_d_H_i_s").".jpeg");
      
      $data = [
          'id_kategori' => $post['id_kategori'],
          'judul' => $post['judul'],
          'tgl_release' => $post['tgl_release'],
          'deskripsi' => $post['deskripsi'],
          'penulis' => $post['penulis'],
          'status' => $post['status'],
          'cover' => str_replace("images/cover/","",$cover)
      ];
      
      $this->db->insert("manga",$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil, data berhasil disimpan!'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;      
    }

    public function tambah_chapter() {
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);
      
      $data = [
          'id_manga' => $post['id_manga'],
          'chapter' => $post['chapter'],
          'judul_chapter' => $post['judul_chapter'],
          'tanggal' => $post['tanggal']
      ];
      
      $this->db->insert("chapter",$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil, data berhasil disimpan!'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;      
    }

    public function tambah_detail() {
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);

      $gambar = $this->base64_to_jpeg($post['gambar'],"images/chapter/".date("Y_m_d_H_i_s").".jpeg");
      
      $data = [
          'id_chapter' => $post['id_chapter'],
          'gambar' => str_replace("images/chapter/","",$gambar)
      ];
      
      $this->db->insert("detail",$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil, data berhasil disimpan!'
      );

      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;      
    }

    public function update_kategori($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);
      
      $data = [
          'nama_kategori' => $post['nama_kategori']
      ];
      
      $this->db->where('id_kategori',$id);
      $this->db->update('kategori',$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil diupdate'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function update_manga($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);
      
      $data = [
        'id_kategori' => $post['id_kategori'],
        'judul' => $post['judul'],
        'tgl_release' => $post['tgl_release'],
        'deskripsi' => $post['deskripsi'],
        'penulis' => $post['penulis'],
        'status' => $post['status']
      ];
      
      $this->db->where('id_manga',$id);
      $this->db->update('manga',$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil diupdate'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function update_chapter($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));
      
      $post = json_decode(file_get_contents("php://input"), true);
      
      $data = [
        'id_manga' => $post['id_manga'],
        'chapter' => $post['chapter'],
        'judul_chapter' => $post['judul_chapter'],
        'tanggal' => $post['tanggal']
      ];
      
      $this->db->where('id_chapter',$id);
      $this->db->update('chapter',$data);
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil diupdate'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function hapus_kategori($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));     
      
      $where = array('id_kategori' => $id);
      $this->hapus_model->kategori($where,'kategori');
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil dihapus'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function hapus_manga($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));     
      
      $where = array('id_manga' => $id);
      $this->hapus_model->manga($where,'manga');
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil dihapus'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function hapus_chapter($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));     
      
      $where = array('id_chapter' => $id);
      $this->hapus_model->chapter($where,'chapter');
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil dihapus'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }

    public function hapus_detail($id) {            
      fuc_checktoken($this->input->request_headers('Authorization'));     
      
      $where = array('id_detail' => $id);
      $this->hapus_model->detail($where,'detail');
      
      $response = array(
          'status' => true,
          'data' => null,
          'message' => 'Berhasil dihapus'
      );
  
      $this->output
        ->set_status_header(200)
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;         
    }
}