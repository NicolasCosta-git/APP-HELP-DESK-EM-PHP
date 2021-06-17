function updateAvatar(input) {
  if (input.files && input.files[0]) {
    let reader = new FileReader();
    reader.onload = function (e) {
      try {
        let imgDiv = document.getElementById("user-avatar");
        imgDiv.style.backgroundImage = "url(" + e.target.result + ")";
        imgDiv.style.backgroundRepeat = "no-repeat";
        imgDiv.style.backgroundPosition = "center";
        imgDiv.style.backgroundSize = "cover";
        let avatarName2 = document.getElementById("avatarName");
        avatarName2.innerHTML = document
          .getElementById("file")
          .value.split("\\")[2];
      } catch (error) {
        let img = document.getElementById("user-image");
        img.src = e.target.result;
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function updateAvatar2(input) {
  if (input.files && input.files[0]) {
    let reader = new FileReader();
    reader.onload = function (e) {
      let img = document.getElementById("avatar");
      img.style.backgroundImage = "url(" + e.target.result + ")";
      img.style.backgroundRepeat = "no-repeat";
      img.style.backgroundPosition = "center";
      img.style.backgroundSize = "cover";
      let avatarName = document.getElementById("avatarName");
      avatarName.innerHTML = document
        .getElementById("photo")
        .value.split("\\")[2];
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function endCall(event) {
  this.event.preventDefault();
  document.getElementById("end-call").submit();
}

function scroll() {
  try {
    document.getElementById("scroll-target").scrollIntoView();
  } catch {}
}
