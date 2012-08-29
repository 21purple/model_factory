<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Model_factory_base extends CI_Model 
{
    protected $table_name = '';
    
    protected $primary_key = '';
    
    protected $db_cols = array();

    protected $db_keys = array();
    
    /**
     * __construct
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function __construct() 
    {
        parent::__construct();
        
        $this->EE = get_instance();
    
        $this->EE->load->helper(array('arr'));
    }
    
    /**
     * get
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function get($id = null) 
    {
        $model = array();
        
        if ($id == null) return $model;

        $model = $this->db->from($this->table_name())->where($this->primary_key(), $id)->limit(1)->get()->row_array();
        
        return $model;
    }
    
    /**
     * get_all
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function get_all($options = array()) 
    {
        $models = array();
        
        $query = $this->db->get($this->table_name());
        
        foreach ($query->result_array() as $model) 
        {
            $models[] = $model;
        }
        
        return $models;
    }

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function save($data)
    {
        $primary_key = $this->primary_key();

        if (isset($data[$primary_key]))
        {
            return $this->update($data[$primary_key], $data);
        }
        else
        {
            return $this->create($data);
        }
    }

    /**
     * create
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function create($data) 
    {
        $model_data = Arr::extract($data, array_keys($this->db_cols));
                    
        $this->db->insert($this->table_name(), $model_data);
        
        return $this->db->insert_id();
    }

        /**
     * create
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function update($model_id, $data) 
    {
        $primary_key = $this->primary_key();

        $model_data = Arr::extract($data, array_keys($this->db_cols()));

        if (isset($model_data[$primary_key]))
        {
            unset($model_data[$primary_key]);
        }
        
        $this->db->where($this->primary_key(), $model_id)->update($this->table_name(), $model_data);
        
        return true;
    }
        
    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function delete($model_id)
    {
        $primary_key = $this->primary_key();

        if ($primary_key)
        {
            $this->db->where($primary_key, $model_id)->delete($this->table_name());
        }
    }


    /**
     * primary_key
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function primary_key() 
    {
        return $this->primary_key;
    }
    
    /**
     * db_cols
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function db_cols() 
    {
        return $this->db_cols;
    }    
    
    /**
     * db_keys
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function db_keys() 
    {
        return $this->db_keys;
    }    
    
    /**
     * table_name
     *
     * @access public
     * @param  void 
     * @return void
     * 
     **/
    public function table_name() 
    {
        return $this->table_name;
    }

}

