<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('organiztion')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('role')->nullable();
            $table->string('link')->nullable();
            $table->string('type');
            $table->timestamps();
        });

    }
}
