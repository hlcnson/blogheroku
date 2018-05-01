@extends('layouts.manage')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10 m-b-0">
            <div class="column">
                <h1 class="title is-admin is-4">Add New Blog Post</h1>
            </div>
            <div class="column">
            
            </div>
        </div>
        <hr class="m-t-0">

        <form action="{{route('posts.store')}}" method="post">
            {{ csrf_field() }}
            <div class="columns">
                <div class="column is-three-quarters-desktop">
                    <b-field>
                        {{-- Bind 2 chiều với thuộc tính title của Vue model --}}
                        <b-input type="text" placeholder="Post Title" size="is-large" v-model="title">
                        </b-input>
                    </b-field>


                    {{-- Sử dụng Vue component tại đây để kết xuất slug theo tiêu đề của bài post, chú ý tên thẻ của component viết tách rời băng dấu -, tên của file component theo cú pháp Camel case. 
                    url, subdirectory, title là các thuộc tính của component.
                    Phần trong {{}} là cú pháp Laravel, phương thức url cho kết quả là chuỗi url của ứng dụng nối với chuỗi đối số.
                    Sử dụng directive v-bind để bind với thuộc tính title của Vue model.
                    Nếu component xảy ra sự kiện tên slugChanged, kích hoạt phương thức updateSlug của đối tượng Vue trong view này, sự kiện slugChanged phát sinh có kèm theo dữ liệu, dữ liệu này sẽ được truyền như một đối số cho phương thức updateSlug, không dùng cặp dấu () sau tên phương thức updateSlug, việc này sẽ ngăn chặn phương thức nhận đối số do sự kiện truyền vào. --}}
                    <slug-widget url="{{url('/')}}" subdirectory="blog" :title="title" @slug-changed="updateSlug"></slug-widget>

                    {{-- Field để bind với thuộc tính slug của Vue model và post về server --}}
                    <input type="hidden" name="slug" v-model="slug">

                    <b-field class="m-t-40">
                        <b-input type="textarea"
                            placeholder="Compose your masterpiece..." rows="20">
                        </b-input>
                    </b-field>
                </div> <!-- end of .column.is-three-quarters -->

                <div class="column is-one-quarter-desktop is-narrow-tablet">
                    <div class="card card-widget">
                        <div class="author-widget widget-area">
                            <div class="selected-author">
                                <img src="https://placehold.it/50x50"/>
                                <div class="author">
                                    <h4>Alex Curtis</h4>
                                    <p class="subtitle">
                                    (jacurtis)
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="post-status-widget widget-area">
                            <div class="status">
                                <div class="status-icon">
                                    <b-icon icon="file-document" size="is-medium"></b-icon>
                                </div>
                                <div class="status-details">
                                    <h4><span class="status-emphasis">Draft</span> Saved</h4>
                                    <p>A Few Minutes Ago</p>
                                </div>
                            </div>
                        </div>
                        <div class="publish-buttons-widget widget-area">
                                <div class="secondary-action-button">
                                    <button class="button is-info is-outlined is-fullwidth">Save Draft</button>
                                </div>
                                <div class="primary-action-button">
                                    <button class="button is-primary is-fullwidth">Publish</button>
                                </div>
                        </div>
                    </div>
                </div> <!-- end of .column.is-one-quarter -->
            </div>
        </form>
    </div> <!-- end of .flex-container -->
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                title: '',  // Tiêu đề của post
                slug: '',    // Lưu ý, thuộc tính slug này là của đối tượng Vue trong file view này.
                api_token: '{{Auth::user()->api_token}}'    // Chứa api token của user để được chứng thực, dùng cú pháp blade ở đây để kết xuất token. Giá trị của thuộc tính data này sẽ được component con truy xuất
            },
            methods: {
                updateSlug: function(val) {     // Phương thức này nhận đối số val từ sự kiện slug-changed của component slug-widget
                    this.slug = val;  // Cập nhật lại giá trị thuộc tính slug của đối tượng Vue trong view
                }
            }
        });
    </script>
@endsection