<div class="w3-padding-top-64 w3-content w3-display-container" style="margin-top: 16px">

    <div class="w3-display-container mySlides">
      <img src="{{ asset('storage/' . $slide[0]->image1) }}" style="width:100%">
      <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
      border-radius: 0.2rem">
         {{ $slide[0]->title1 }}
      </div>
    </div>

    <div class="w3-display-container mySlides">
      <img src="{{ asset('storage/' . $slide[0]->image2) }}" style="width:100%">
      <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
      border-radius: 0.2rem">
        {{ $slide[0]->title2 }}
      </div>
    </div>

    <div class="w3-display-container mySlides">
      <img src="{{ asset('storage/' . $slide[0]->image3) }}" style="width:100%">
      <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
      border-radius: 0.2rem">
        {{ $slide[0]->title3 }}
      </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image4) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title4 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image5) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title5 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image6) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title6 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image7) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title7 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image8) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title8 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image9) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title9 }}
        </div>
    </div>

    <div class="w3-display-container mySlides">
        <img src="{{ asset('storage/' . $slide[0]->image10) }}" style="width:100%">
        <div class="mx-36 w3-display-bottomleft w3-large w3-container w3-padding-small" style="background: black; color: aliceblue;
        border-radius: 0.2rem">
          {{ $slide[0]->title10 }}
        </div>
    </div>


    <button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)">&#10094;</button>
    <button class="w3-button w3-display-right w3-black" onclick="plusDivs(1)">&#10095;</button>

    </div>

    <script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      if (n > x.length) {slideIndex = 1}
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";
      }
      x[slideIndex-1].style.display = "block";
    }
    </script>