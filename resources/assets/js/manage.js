// Sử dụng chuẩn ECMA 2016 (không cần ; cuối lệnh)

// Code xử lý ẩn/hiện menu trái trên màn hình mobile
// Lấy phần tử nút hiện/ẩn menu trái trên màn hình mobile
const adminSlideoutButton = document.getElementById('admin-slideout-button')
if (adminSlideoutButton) {
    // Đăng ký sự kiện click cho nút ẩn/hiện menu trái
    adminSlideoutButton.onclick = function(){
        // Toggle class tên is-active cho nút lệnh
        this.classList.toggle('is-open')
        document.getElementById('admin-side-menu').classList.toggle('is-active')
    }
}



// Code tạo hiệu ứng accordion
// Lấy danh sách các phần tử có class là has-submenu
const accordions = document.getElementsByClassName('has-submenu')
// Duyệt qua từng submenu
for (let i = 0; i < accordions.length; i++) {
    // Nếu một accordion menu đang active thì mở menu đó
    if (accordions[i].classList.contains('is-active')){
        // Mở submenu
        const submenu = accordions[i].nextElementSibling
        // Thuộc tính scrollHeight cho chiều cao của phần tử, bao gồm cả padding 
        // nhưng không tính border, srollbar và margin, tính bằng px, 
        submenu.style.maxHeight = submenu.scrollHeight + 'px'
        submenu.style.marginTop = '0.75em'
        submenu.style.marginBottom = '0.75em'
    }


    // Đăng ký function (không được dùng cú pháp arrow function ở đây vì đối tượng this
    // sẽ không được truyền vào trong hàm) xử lý sự kiện click của submenu
    accordions[i].onclick = function() {
        // this.classList.toggle('is-active')
        // Lấy phần tử anh em tiếp theo trong DOM, có class là submenu
        const submenu = this.nextElementSibling
        if (submenu.style.maxHeight){   // Thuộc tính max-height>0, tức submenu đang mở
            // Đóng submenu
            submenu.style.maxHeight = null
            submenu.style.marginTop = null
            submenu.style.marginBottom = null
        } else {    // submenu đang đóng, mở nó ra
            // Mở submenu
            // Thuộc tính scrollHeight cho chiều cao của phần tử, bao gồm cả padding 
            // nhưng không tính border, srollbar và margin, tính bằng px, 
            submenu.style.maxHeight = submenu.scrollHeight + 'px'
            submenu.style.marginTop = '0.75em'
            submenu.style.marginBottom = '0.75em'
        }
    }
}