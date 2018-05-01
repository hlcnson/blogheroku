<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            // Tạo file slug để xác định bài post, đồng thời tạo index 
            // trên field này để việc tìm kiếm trên field được nhanh hơn.
            $table->string('slug')->unique();
            // Tạo một field khóa ngoại kiểu số nguyên không dấu 
            // chứa id tác giả bài post (cũng chính là user id)
            $table->integer('author_id')->unsigned();
            // Tiêu đề bài post
            $table->string('title');
            // Summary của post
            $table->text('excerpt');
            // Nội dung bài post
            $table->longText('content');
            // Trạng thái, giá trị mặc định là 1
            $table->integer('status')->default(1);
            // Loại
            $table->integer('type')->unsigned()->default(1);
            // Số lượng comment
            $table->bigInteger('comment_count')->unsigned();
            // Ngày xuất bản bài post
            $table->dateTime('published_at');
            $table->timestamps();
            // Tạo tham chiếu cho khóa ngoại lên field id của bảng users,
            // ràng buộc khi xóa user
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
