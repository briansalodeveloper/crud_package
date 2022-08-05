<?php

namespace Brian\Crud;

class Crud
{

    public function plustest(int $first = 1, int $second = 2)
    {
        return $first + $second;
    }
    public function getModel($model)
    {
        dd($model);
    }

    /**
     * acquire all model records
     * call NTC (No Try Catch) method
     *
     * @return Collection
     */
    public function acquireAll()
    {
        $rtn = $this->arrayToCollection([]);
     
        try {
            $rtn = $this->NTCacquireAll();
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * acquire all model records
     * NTC (No Try Catch) method
     *
     * @return Collection
     */
    public function NTCacquireAll()
    {
        $rtn = $this->arrayToCollection([]);

        if (!empty($this->Model)) {
            $rtn = $this->Model::all();
        }

        return $rtn;
    }

    /**
     * acquire a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Model
     */
    public function acquire($model, $id)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCacquire($model, $id);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * acquire a model record
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Model
     */
    public function NTCacquire($model, $id)
    {
        $rtn = false;

        if (!empty($model) && !empty($id)) {
            $rtn = $model::find($id);
        }

        if (empty($rtn)) {
            $rtn =  $model::empty();
        }

        return $rtn;
    }
    /**
     * add a model record
     * call NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @return Bool/Model
     */
    public function add($model, array $attributes)
    {
        $rtn = false;
        try {
            $rtn = $this->NTCadd($model, $attributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error('Exception: ' . $e->getMessage());
        }

        return $rtn;
    }

    /**
     * add a model record
     * NTC (No Try Catch) method
     *
     * @param Array $attributes
     * @return Bool/Model
     */
    public function NTCadd($model, array $attributes)
    {
        $rtn = false;

        if (!empty($model) && count($attributes) != 0) {
            $rtn = $model::create($attributes);
            
            if ($rtn) {
                $rtn = $rtn->fresh();
            }
        }

        return $rtn;
    }

    /**
     * adjust a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @param Array $attributes
     * @return Bool/Model
     */
    public function adjust($model, int $id, array $attributes)
    {
        $rtn = false;
        try {
            $rtn = $this->NTCadjust($model, $id, $attributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * adjust a model record
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @param Array $attributes
     * @return Bool/Model
     */
    public function NTCadjust($model, int $id, array $attributes)
    {
        $rtn = false;

        if (!empty($model) && count($attributes) != 0) {
            $retrieveModel = $this->NTCacquire($model, $id);

            if (!$retrieveModel->isEmpty) {
                $rtn = $retrieveModel->update($attributes);

                if ($rtn === 0) {
                    $rtn = true;
                }

                if ($rtn) {
                    $rtn = $retrieveModel->fresh();
                }
            }
        }

        return $rtn;
    }

    /**
     * annul a model record
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Bool
     */
    public function annul($model, int $id)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCannul($model, $id);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * annul a model record
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Bool
     */
    public function NTCannul($model, int $id)
    {
        $rtn = false;

        if (!empty($model)) {
            $retrieveModel = $this->NTCacquire($model, $id);
            $rtn = $retrieveModel->delete();
        }

        return $rtn;
    }

    /**
     * retrieve a model record base on the condition
     * call NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Bool
     */
    public function where($model, array $attributes)
    {
        $rtn = false;

        try {
            $rtn = $this->NTCwhere($model, $attributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
        } catch (\Error $e) {
            \Log::error($e->getMessage());
        }

        return $rtn;
    }

    /**
     * retrieve a model record base on the condition
     * NTC (No Try Catch) method
     *
     * @param Int $id
     * @return Bool
     */
    public function NTCwhere($model, array $attributes)
    {
        $rtn = false;

        if (!empty($model)) {
            $query = false;
            $count = 0;

            foreach($attributes as $index => $attribute) {                
                $count++;

                if (count($attributes) == $count) {
                    $query = $model::whereIn('id',$query)->where($index,$attribute)->get();
                } elseif($count == 1) {
                    $query = $model::where($index,$attributes)->pluck('id');
                } else{
                    $query = $model::whereIn('id',$query)->where($index,$attribute)->pluck('id');
                }
            }

            if($query) {
                $rtn = $query;
            }

        }

        return $rtn;
    }

}
