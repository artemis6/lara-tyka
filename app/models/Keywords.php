<?php

class Keyword extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'iit_keywords';

    /**
     * Do not maintain ORM creation records for this model
     *
     * @var bool
     */
    public $timestamps = false;

    public function verse() {
        return $this->hasOne('Verse');
    }
}
