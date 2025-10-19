$(function () {
  $(document).on("click", "#ReceivedDialog", function (e) {
    e.preventDefault(); // Stop default navigation first

    const link = $(this).attr("href");

    Swal.fire({
      title: "Confirm Receive",
      text: "Are you sure you want to mark this as received?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, mark as received",
      cancelButtonText: "Cancel",
      reverseButtons: true, // better UX
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: "Processing...",
          text: "Please wait",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        // Use setTimeout to ensure Swal shows first before redirect
        setTimeout(() => {
          window.location.href = link;
        }, 300);
      }
    });
  });
});
