function isChecked() {
    if(document.getElementById("status").checked){
        document.getElementById("status-info").textContent = "1";
    }
    else {
        document.getElementById("status-info").textContent = "0";
    }
  }