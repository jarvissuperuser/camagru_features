var file = document.getElementById('fu');
  //loads file into ram::
  function ajx(th){
    var f = new FileReader();
    f.readAsBinaryString(th[0]);
    var tx = {};
    f.onload = function (e){
      tx = btoa(e.target.result);
      //document.getElementById('rsp').innerHTML = '<img src="data:'+th[0].type +';base64,' + tx + '"/>';
      var formdt = new FormData();
      formdt.append('submit','file');
      formdt.append('data',tx);
      formdt.append('type',encodeURI(th[0].type));
      var ax = new XMLHttpRequest();
      ax.addEventListener('load',function(){console.log(this.responseText);
        tx=null;e = null;
        ax.removeEventListener('load',this);
      });
      
      ax.open('POST','./uploadtest.php?submit=file&type='+encodeURI(th[0].type));
      ax.send(formdt);
    };
  }


