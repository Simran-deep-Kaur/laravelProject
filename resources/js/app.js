import "./bootstrap";
import Swal from "sweetalert2";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", (event) => {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire("Deleted!", "Your item has been deleted.", "success").then((result)=>{
                    if(result.isConfirmed){
                        event.target.closest('form').submit();
                    }
                })
              
            }
        });
    });
});



