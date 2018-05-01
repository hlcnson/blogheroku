
<style scoped>
    .slug-widget, .wrapper {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }
    .wrapper {
        margin-left: 8px;
    }
    .wrapper .button {
        margin-left: 5px;
    }
    .slug {
        background: #fdfd96;
        padding: 3px 5px;
    }
    .input {
        width: auto;
    }
</style>


<template>
    <div class="slug-widget">
        <div class="icon-wrapper wrapper">
            <i class="fa fa-link"></i>
        </div>
        <div class="url-wrapper wrapper">
            <!-- Chèn các ghi chú giữa các thẻ span để ngăn trình duyệt chèn thêm khoảng trắng giữa chúng -->
            <span class="root-url">{{url}}</span><!-- 
            --><span class="subdirectory-url">/{{subdirectory}}/</span><!-- Directive v-show làm cho phần tử span này
            chỉ được hiển thị khi thuộc tính slug của component có giá trị và thuộc tính isEditing là false.
            --><span class="slug" v-show="slug && !isEditing">{{slug}}</span>
            <!-- Phần tử span này chỉ xuất hiện khi thuộc tính isEditing là true -->
            <span class="slug-edit" v-show="isEditing">
                <!-- Phần tử này 2-way binding với thuộc tính customSlug của component -->
                <input type="text" name="slug" v-model="customSlug" class="input">
            </span>
        </div>
        <div class="button-wrapper wrapper">
            <!-- Cú pháp .stop nhằm ngăn chặn sự kiện click làm trình duyệt nạp lại trang đang hiển thị -->
            <button class="edit-slug-button button is-small is-primary" v-show="!isEditing" v-on:click.prevent="editSlug">Edit</button>
            <button class="save-slug-button button is-small is-primary" v-show="isEditing" v-on:click.prevent="saveSlug">Save</button>
            <button class="reset-slug-button button is-small is-primary" v-show="isEditing" v-on:click.prevent="resetEditing">Reset</button>
        </div>
    </div>    
</template>

<script>
    export default {
        props: {    // Định nghĩa các thuộc tính của component tại đây
            url: {
                type: String,       // Kiểu dữ liệu
                required: true      // Bắt buộc có giá trị
            },
            subdirectory: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            }
        },
        data: function() {
            return {
                slug: this.setSlug(this.title),  // Chứa slug tự động tính bằng thư viện slug.js
                isEditing: false,   // Cờ báo hiệu chế độ edit slug
                customSlug: '',     // Chứa slug tùy biến
                wasEdited: false,   // Cờ báo hiệu slug đã được tùy biến
                api_token: this.$root.api_token         // Chứa api_token của user để thực hiện 
                                                        // HTTP request đến api route.
                // Sử dụng kỹ thuật truy xuất dữ liệu của component gốc (trong cây component) 
                // từ bên trong một component con.
            }
        },
        methods: {
            editSlug: function() {
                this.customSlug = this.slug     // Gán giá trị của slug tùy biến bằng slug tính tự động
                // this.$emit('edit', this.slug)     // Phát sinh sự kiện của component tên edit, kèm theo giá trị của slug
                this.isEditing = true   // Chuyển sang chế độ edit giá trị slug
            },
            saveSlug: function() {
                // Cần kích hoạt hàm ajax tại đây để kiểm tra tính duy nhất của slug

                if (this.customSlug !== this.slug) {    // slug đã được tùy biến
                    this.wasEdited = true   // Báo hiệu slug đã được tùy biến
                }
                // Tính lại slug tùy biến
                this.setSlug(this.customSlug)
                // this.$emit('save', this.slug)     // Phát sinh sự kiện của component tên save, kèm theo giá trị của slug
                this.isEditing = false  // Kết thúc chế độ edit slug
            },
            resetEditing: function() {
                // Tính lại slug theo tiêu đề bài post
                this.setSlug(this.title)
                this.wasEdited = false  // Chuyển slug sang trạng thái không tùy biến
                // this.$emit('reset', this.slug)     // Phát sinh sự kiện của component tên reset, kèm theo giá trị của slug
                this.isEditing = false  // Kết thúc chế độ edit slug
            },
            // Setter method để tính toán giá trị cho thuộc tính slug
            setSlug: function (newVal, count = 0) {
                // Tạo một biến cục bộ tên slug, khác với biến toàn cục this.slug, chỉ có giá trị trong method này.
                // Nếu đối số count có giá trị > 0, nối chuỗi giá trị của count vào slug băng cú pháp template string
                let slug = Slug(newVal + (count > 0 ? `-${count}` : '')) // Đối tượng Slug (thư viện slug.js) được định nghĩa trong app.js

                // Tạo một biến chứa Vue component hiện tại
                let vc = this

                // Nếu component đã có giá trị của api_token và slug thì mới tạo api request
                if (this.api_token && slug) {
                    // Kiểm tra tính duy nhất của slug mới được tính toán để không bị trùng lặp.
                    // Dùng thư viện axios để tạo HTTP request đến api route tên api.posts.unique, kèm theo tham số cho route
                    axios.get('/api/posts/unique', {
                        params: {
                            api_token: vc.api_token,    // Tham số tên api_token, vc thay thế cho this
                            slug: slug                  // Tham số tên slug, lấy giá trị từ biến cục bộ slug
                        }
                    }).then(function(response){         // Promise cho trường hợp success
                        if (response.data) {            // Kết quả kích hoạt api route là true, slug không trùng
                            vc.slug = slug      // Gán giá trị cho thuộc tính data tên slug của component là biến slug cục bộ
                            vc.$emit('slug-changed', slug)    // Nếu slug thay đổi, phát sinh sự kiện tên slug-changed
                        } else {        // Kết quả là false, slug bị trùng
                            // Đệ qui để tính lại slug mới
                            vc.setSlug(newVal, count + 1)
                        }
                    }).catch(function(error) {          // Promise cho trường hợp bị lỗi
                        console.log(error)
                    })
                }
            }
        },
        watch: {                    // Theo dõi thay đổi giá trị thuộc tính
            title:  // Nếu thuộc tính title thay đổi
                _.debounce(function() {     // Dùng hàm debounce của thư viện lodash
                    if (this.wasEdited === false) { // Nếu slug không được tùy biến
                        this.slug = this.setSlug(this.title) // Tính lại slug cho bài post
                    }
                    // Cần kích hoạt hàm ajax tại đây để kiểm tra tính duy nhất của slug
                    // Nếu slug bị trùng lắp, điều chỉnh slug
                }, 500),       // Trì hoãn thực hiện lệnh tính lại slug trong 500ms
            
            // slug: function(val) {       // Theo dõi thay đổi đối với thuộc tính slug
            //     this.$emit('slug-changed', this.slug)    // Nếu slug thay đổi, phát sinh sự kiện tên slug-changed kèm theo dữ liệu là slug. Phải dùng cú pháp dấu - cho tên sự kiện
            // }
        }
    }
</script>
