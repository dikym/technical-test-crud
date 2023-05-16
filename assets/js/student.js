$(document).on("click", ".btn-edit", function () {
  const id = $(this).data("id");
  $.ajax({
    url: "get_student.php",
    type: "post",
    data: {
      id: id,
    },
    dataType: "json",
    success: function (response) {
      $("#id").val(response.id);
      $("#name").val(response.nama);
      $("#gender").val(response.jenis_kelamin);
      $("#address").val(response.alamat);
    },
  });
});
