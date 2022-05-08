window.onload = () => {
}



function deleteAllCookies() {
   const cookies = document.cookie.split(';');

   for (let i = 0; i < cookies.length; i++) {
      const cookie = cookies[i];
      const eqPos = cookie.indexOf('=');
      const name = eqPos > -1 ? cookie.substring(0, eqPos) : cookie;
      document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
   }
}

function leave() {
   const xhr = new XMLHttpRequest();

   xhr.open('POST', 'test.php', true);

   xhr.onload = function () {
      if (this.status == 200) {
         console.log(this.responseText);
      }

   }
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')

   xhr.send();
}