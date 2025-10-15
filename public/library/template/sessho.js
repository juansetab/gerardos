function s_SwalFire(sw_icon, sw_title, sw_text, sw_confirmColor = "#33FFEC") {
  Swal.fire({
    icon: sw_icon,
    title: sw_title,
    text: sw_text,
    confirmButtonColor: sw_confirmColor,
  });
}

function s_Serialize(array) {
  serialize = "";
  Object.keys(array).forEach((key) => {
    serialize += key + "=" + array[key] + "&";
  });
  return serialize.slice(0, -1);
}

function s_Datatable(table) {
  return (dataTable = new simpleDatatables.DataTable(`#${table}`, {
    perPage: 50,
    perPageSelect: [10, 50, 100, 250, 500],
  }));
}

function s_AJAX(url, array, succesFunction) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      data = JSON.parse(this.responseText);
      if (data.status == 1) {
        succesFunction(data.data);
      } else {
        s_SwalFire("warning", "¡Importante!", data.msg);
      }
    } else if (this.readyState == 4 && this.status != 200) {
      s_SwalFire("error", "Error status: " + this.status, this.readyState);
    }
  };
  xhttp.open("POST", url);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(s_Serialize(array));
}

function s_UpdateRow(link) {
  data = document.forms["form_edit"].reportValidity();
  if (!data) return false;
  data = $("#form_edit").serialize();
  $.ajax({
    url: BASE_URL + link,
    data: data,
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        //Redibujar el row
        s_SwalFire("success", "¡Actualizado!", data.msg);
        id = $("#form_edit #id").val();
        $("#tr_" + id)
          .find("td")
          .each(function (index) {
            if (index != 0) {
              if ($("#form_edit #" + $(this).attr("id")).is("input")) {
                value = $("#form_edit #" + $(this).attr("id")).val();
              } else if ($("#form_edit #" + $(this).attr("id")).is("select")) {
                value = $(
                  "#form_edit #" + $(this).attr("id") + " option:selected"
                ).html();
                console.log(value);
                if (value == undefined) {
                  value = $("#form_edit #" + $(this).attr("id")).val();
                }
              }
              $(this).html(value);
            }
          });
      } else {
        s_SwalFire("error", "¡Error!", data.msg);
      }
      $(" #modal_edit").modal("hide");
    },
    error: function (xhr, status) {
      s_SwalFire("error", "Ha ocurrido un problema", status + xhr);
    },
  });
}

function s_insertRow(link) {
  data = $("#form_insert").serialize();
  $.ajax({
    url: BASE_URL + link,
    data: data,
    type: "POST",
    dataType: "json",
    success: function (response) {
      if (response.status == 1) {
        s_SwalFire("success", "¡Guardado!", data.msg);
        $("#modal_insert").modal("hide");
        setTimeout(() => {
          location.reload();
        }, "1000");
      } else {
        s_SwalFire("error", "¡Error!", data.msg);
      }
    },
    error: function (xhr, status) {
      s_SwalFire("error", "Ha ocurrido un problema", status + xhr);
    },
  });
}

function s_deleteRow(id, link, tr) {
  Swal.fire({
    title: "¿Desea eliminar el elemento?",
    showCancelButton: true,
    confirmButtonText: "Eliminar",
    cancelButtonText: "No eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: link,
        data: { delete_id: id },
        type: "POST",
        dataType: "json",
        success: function (data) {
          s_SwalFire("success", "¡Éxito!", data.msg);
          tr.remove();
        },
        error: function (xhr, status) {
          s_SwalFire("error", "¡Error!", "Existió un problema al procesar la solicitud. " + status + xhr);
        },
      });
    }
  });
}

function s_CurrencyFormat(number) {
  return new Intl.NumberFormat("en-EN", {
    style: "currency",
    currency: "USD",
    minimumFractionDigits: 2,
  }).format(number);
}

function s_DeleteHTMLRow(btn, succesFunction) {
  btn.parentNode.parentNode.parentNode.remove();
  succesFunction();
}

function s_CallModalEdit(element) {
  tr = $(element).parent().parent().parent();
  $("#form_edit #id").val($(tr).data("id-row"));
  $(tr)
    .find("td")
    .each(function (index) {
      if (index != 0) {
        $("#form_edit #" + $(this).attr("id")).val($(this).html());
        if ($("#form_edit #" + $(this).attr("id")).is("select")) {
          value = $(
            `#form_edit #` +
              $(this).attr("id") +
              ` option[value="` +
              $(this).html() +
              `"]`
          ).html();
          if (value == undefined) {
            table_row = this;
            $($("#form_edit #" + $(this).attr("id")))
              .find("option")
              .each(function (i, v) {
                if ($(v).html() == $(table_row).html()) {
                  $(v).prop("selected", true);
                }
              });
          }
        }
      }
    });
  var modalEdit = new bootstrap.Modal(document.getElementById("modal_edit"), {
    keyboard: false,
  });
  modalEdit.show();
}

function is_Empty(array) {
  empty = false;
  array.forEach(function (value, index) {
    if (value == "") {
      empty = true;
    }
  });
  return empty;
}

function s_Mayus() {
  $("input").change(function () {
    val = $(this).val().toUpperCase();
    $(this).val(val);
  });
}

function s_Dummy() {}

function s_SendForm(){
  
}
