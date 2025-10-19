$(function () {
  const btn = document.getElementById("PrintDialog");
  if (btn) {
    const receiptLink = $(btn).data("receipt");
    const posLink = $(btn).data("pos");

    Swal.fire({
      title: "Print Receipt?",
      text: "Do you want to print this receipt now?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, Print",
      cancelButtonText: "No, Skip",
      reverseButtons: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = receiptLink;
      } else {
        window.location.href = posLink;
      }
    });
  }
});
