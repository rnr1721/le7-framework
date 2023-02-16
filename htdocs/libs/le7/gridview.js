window.addEventListener('load', function () {

    let search = document.getElementById("search");

    search.addEventListener("keyup", function () {
        filter_input('table','tcontent');
    });

});


function filter_input(table_name,tr_class) {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById(table_name);
  tr = table.getElementsByClassName(tr_class);
  for (var i = 0; i < tr.length; i++) {
    var tds = tr[i].getElementsByTagName("td");
    var flag = false;
    for(var j = 0; j < tds.length; j++){
      var td = tds[j];
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        flag = true;
      } 
    }
    if(flag){
        tr[i].style.display = "";
    }
    else {
        tr[i].style.display = "none";
    }
  }
}