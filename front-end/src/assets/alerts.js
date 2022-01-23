module.exports = function (
    value,
    type,
    important = false,
    timeout = 2500
){
    if (important === true) {
        this.$swal.fire({
            icon: type,
            title: "Uwaga!",
            timerProgressBar: true,
            timer: timeout,
            html: value,
        });
    } else {
        this.$swal.fire({
            position: "bottom-start",
            icon: type,
            title: value,
            showConfirmButton: false,
            timer: timeout,
            toast: true,
            timerProgressBar: true,
        });
    }
};
