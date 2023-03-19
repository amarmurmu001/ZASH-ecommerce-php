<div class="footer">
            <div class="footer-col">
                <h2>About</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi ipsa, nihil eligendi tenetur molestias dolor amet explicabo. Unde distinctio quis ipsam.</p>
            </div>
            <div class="footer-col">
                <h2>Contact</h2>
                <ul>
                    <li><i class="fa-solid fa-location-dot"></i> Silli Polytechnic ,Silli,Ranchi ,835102</li>
                    <li><i class="fa-solid fa-phone"></i> Mobile: 987654321</li>
                    <li><i class="fa-solid fa-envelope"></i> Email:zash@mail</li>
                </ul>
            </div>
            <div class="footer-col">
                <h2>Categories</h2>
                <ul>
                    <li><a href="">Headphones</a></li>
                    <li><a href="">Smart Watches</a></li>
                    <li><a href="">Bluetooth Speaker</a></li>
                    <li><a href="">Wireless Earbud</a></li>
                    <li><a href="">Home Theatre</a></li>
                    <li><a href="">Projector</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h2>Pages</h2>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="">Privacy Policy</a></li>
                    <li><a href="">Returns</a></li>
                    <li><a href="">Terms & Condition</a></li>
                    <li><a href="">Contact us</a></li>
                </ul>
            </div>
        </div>
        <div class="copy-right flex-copy">
            <p>Date & time - </p>
            <p id="datetime"></p>

            <p>Made with <i class="fa-solid fa-heart"></i> by ZASH. </p>

        </div>

        <script>
            function displayDateTime() {
                var date = new Date();
                document.getElementById("datetime").innerHTML = date.toLocaleString();
            }
            setInterval(displayDateTime, 1000);
        </script>