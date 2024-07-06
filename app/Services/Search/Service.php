<?php

namespace App\Services\Search;

class Service
{

    public function multipleSearch ($query, $fields, $search) {

        $search = trim($search);


        return $query->where(function ($query) use($fields, $search) {

            foreach ($fields as $key => $field) {

                if($key === 0) {
                    $query->where($field, 'like', '%' . $search . '%');
                }
                else {
                    $query->orWhere($field, 'like', '%' . $search . '%');
                }

            }

            $query->get();

        }
        )->get();

    }

}
