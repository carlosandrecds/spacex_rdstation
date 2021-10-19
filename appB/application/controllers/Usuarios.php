<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct() {
        parent::__construct();

        $this->iduser = $this->session->userdata('id');

        $this->menuativo = strtolower(base_url().get_class());

		$this->configuracao = (object) [
			'tabela' => 'usuarios',
			'descritivo' => 'Usuarios',
			'subtitulo' => 'Gerenciamento de Usuários',
			'chave' => 'idusuario',
			'colunas' => [
				'idusuario' 	=> (object) ['tipo' => 'int', 'descricao' => '#'],
				'nome'			=> (object) ['tipo' => 'varchar', 'descricao' => 'Nome', 'tamanho' => 8],
				'email'			=> (object) ['tipo' => 'varchar', 'descricao' => 'E-mail', 'tamanho' => 2],
				'status'		=> (object) ['tipo' => 'decimal', 'descricao' => 'Status'],
			],
			'colunas_view' => [
				'idusuario' 	=> (object) ['tipo' => 'int', 'descricao' => '#'],
				'nome'			=> (object) ['tipo' => 'varchar', 'descricao' => 'Nome'],
				'email'			=> (object) ['tipo' => 'varchar', 'descricao' => 'E-mail'],
			],
			'colunas_editar' => [
				'nome'			=> (object) ['tipo' => 'varchar', 'descricao' => 'Nome'],
				'valor'			=> (object) ['tipo' => 'decimal', 'descricao' => 'Valor'],
			]
		];
    }

	public function index()
	{
        return $this->listagem();		
	}

    function listagem(){

		$this->load->library('table');
        $this->load->library('pagination');
		
		$config['base_url'] = strtolower(base_url().get_class()).'/listagem';
        $config['total_rows'] = $this->db->query("select count(".$this->configuracao->chave.") total 
												  from ".$this->configuracao->tabela." where status = 1")->result()[0]->total;
												  
		$this->data['total'] = $config['total_rows'];
		
		$config = configuraPaginacao($config);
		
		$this->pagination->initialize($config);
		
		$this->data['paginacao'] = $this->pagination->create_links();
		$inicio = ( is_numeric($this->uri->segment(3)) ) ? $this->uri->segment(3) : 0;
		
		$this->data[$this->configuracao->tabela] = $this->db->query("select * from ".$this->configuracao->tabela." 
														             where status = 1 limit ".$inicio.", ".$config['per_page'])->result();
        $this->data['view'] = $this->configuracao->tabela.'/listagem';
        $this->load->view('app/template', $this->data);
		
    }

    public function adicionar() 
    {

		$this->data = array(
			'button' => 'Adicionar',
			'action' => site_url($this->router->class.'/adicionar_acao')
		);
		
		foreach($this->configuracao->colunas as $c => $v ) :
			$this->data[$c] = set_value($c);
		endforeach;

		$this->data['view'] = $this->configuracao->tabela.'/editar';
		$this->load->view('app/template', $this->data);

    }
	
	public function adicionar_acao() 
    {
		
		$dados = [];
		foreach($this->configuracao->colunas as $c => $v ) :
			if($v->tipo == 'datetime') :
				$dados[$c] = dateTimeToUS($this->input->post($c), true); 
			elseif($v->tipo == 'decimal') :
				$dados[$c] = moeda_unmask($this->input->post($c));
			else:
				$dados[$c] = $dados[$c] = $this->input->post($c, true);
			endif;								
		endforeach;		

		$dados['status'] = 1;
		
		if ( $this->db->insert($this->configuracao->tabela, $dados) ){
        	$this->session->set_flashdata('message', msg_json('Registro adicionado com sucesso!!!', 1) );
        }else{
        	$this->session->set_flashdata('message', msg_json('Erro ao adicionar registro', 1) );
        }
		
		redirect(site_url($this->router->class));
    }
	
	public function editar($id) 
    {
		
		$this->db->where($this->configuracao->chave, $id);
        $row = $this->db->get($this->configuracao->tabela)->row();
		
        if ($row) {
            $this->data = array(
                'button' => 'Atualizar',
                'action' => site_url($this->router->class.'/editar_acao')
			);
			
			foreach($this->configuracao->colunas as $c => $v ) :
					$this->data[$c] = set_value($c, $row->$c);						
			endforeach;

			$this->data['view'] = $this->configuracao->tabela.'/editar';
			$this->load->view('app/template', $this->data);
        } else {
            $this->session->set_flashdata('message', msg_json('Arquivo não encontrado!', 1) );
            redirect(site_url(get_class()));
        }
    }
	
	public function editar_acao() 
    {
		
		$dados = [];
		foreach($this->configuracao->colunas as $c => $v ) :
			if($v->tipo == 'datetime') :
				$dados[$c] = dateTimeToUS($this->input->post($c)); 
			elseif($v->tipo == 'decimal') :
				$dados[$c] = moeda_unmask($this->input->post($c));
			else:
				$dados[$c] = $dados[$c] = $this->input->post($c);
			endif;								
		endforeach;	

		$this->db->where($this->configuracao->chave, $this->input->post($this->configuracao->chave ,TRUE));

        if ( $this->db->update($this->configuracao->tabela, $dados) ){
        	$this->session->set_flashdata('message', msg_json('Registro atualizado com sucesso!', 1) );
        }else{
        	$this->session->set_flashdata('message', msg_json('Erro ao atualizar dados!', 2) );
        }		 
		
		redirect(site_url($this->router->class));
    }
	
	function excluir($id) 
    {	
		
        $this->db->where($this->configuracao->chave, $id);
        $row = $this->db->get($this->configuracao->tabela)->row();
		
        if ($row) {
            $this->db->where($this->configuracao->chave, $id);
			$this->db->update($this->configuracao->tabela, ['status' => 2] );
			
            $this->session->set_flashdata('message', msg_json('Registro deletado com sucesso!', 1) );
            redirect(site_url($this->router->class));
        } else {
            $this->session->set_flashdata('message', msg_json('Registro não encontrado!', 1) );
            redirect(site_url($this->router->class));
        }
    }
}
