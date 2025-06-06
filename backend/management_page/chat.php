<?php

$seller_id = $ses_id;

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;
if ($user_id == 0) {
    echo "User tidak ditemukan.";
    exit;
}
?>



    <div class="kotak-chat-admin">
    <!-- <a class="btn btn-warning text-white" href="?page=dashboard">Kembali</a> -->
    <div class="chat-container">
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <!-- Input file untuk gambar -->
            <input type="file" id="image" accept="image/*" onchange="displayImageName()">
            <!-- Label untuk memilih gambar -->
            <label for="image">Pilih Gambar</label>
            <!-- Tempat menampilkan nama gambar yang dipilih -->
            <div id="image-name"></div>
            
            <input type="text" id="message" placeholder="Tulis pesan...">
            <button onclick="sendMessage()">Kirim</button>
        </div>
    </div>
</div>


<script>
function displayImageName() {
    // Ambil elemen input file
    const fileInput = document.getElementById('image');
    
    // Ambil elemen untuk menampilkan nama file
    const imageNameDisplay = document.getElementById('image-name');
    
    // Periksa apakah ada file yang dipilih
    if (fileInput.files && fileInput.files[0]) {
        // Tampilkan nama file yang dipilih
        const fileName = fileInput.files[0].name;
        imageNameDisplay.textContent = `Gambar yang dipilih: ${fileName}`;
    } else {
        // Jika tidak ada file, kosongkan tampilan
        imageNameDisplay.textContent = '';
    }
}

function sendMessage() {
    const message = document.getElementById('message').value;
    // Ambil gambar jika ada
    const fileInput = document.getElementById('image');
    if (fileInput.files.length > 0) {
        const fileName = fileInput.files[0].name;
        // Kirim pesan beserta nama file atau file itu sendiri
        console.log("Pesan: " + message);
        console.log("Nama file gambar: " + fileName);
    }
    // Kirim pesan biasa jika tidak ada gambar
    if (message.trim() !== "") {
        console.log("Pesan: " + message);
    }
}
</script>


    <script>
        const chatMessages = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message');
        const imageInput = document.getElementById('image');

        function sendMessage() {
            const message = messageInput.value;
            const image = imageInput.files[0];
            const formData = new FormData();
            formData.append('pesan', message);
            if (image) {
                formData.append('gambar', image);
            }
            formData.append('seller_id', <?php echo $seller_id; ?>);
            formData.append('user_id', <?php echo $user_id; ?>);
            formData.append('pengirim_tipe', 'seller');
            formData.append('penerima_tipe', 'user');

            fetch('../kirim_pesan.php', {
                method: 'POST',
                body: formData
            }).then(() => {
                messageInput.value = '';
                imageInput.value = '';
                loadMessages();
            });
        }



        function loadMessages() {
    fetch(`../ambil_pesan.php?seller_id=<?php echo $seller_id; ?>&user_id=<?php echo $user_id; ?>`)
        .then(response => response.json())
        .then(messages => {
            console.log("Pesan yang diterima:", messages); // Debugging

            if (!Array.isArray(messages)) {
                console.error("Data yang diterima bukan array!", messages);
                return;
            }

            chatMessages.innerHTML = '';

            messages.forEach(message => {
                const messageDiv = document.createElement('div');

                // Cek apakah pesan dari user atau seller
                const isUser = message.pengirim_tipe === 'user';
                const messageClass = isUser ? 'user' : 'seller';

                // Set posisi pesan: user di kanan, seller di kiri
                messageDiv.classList.add('chat-message', messageClass);

                // Tampilkan pesan dalam div
                messageDiv.innerHTML = `
                    <div class="message-box">
                        <div class="sender-name">${isUser ? 'User' : 'Penjual'}</div>
                        <div class="message-content ">
                            ${message.pesan ? `<p class="text-white">${message.pesan}</p>` : ''}
                            ${message.gambar ? `<img src="../${message.gambar}" width="100">` : ''}
                        </div>
                    </div>
                `;

                chatMessages.appendChild(messageDiv);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            console.error("Gagal mengambil pesan:", error);
        });
}

        loadMessages();
        setInterval(loadMessages, 5000);

    </script>

<script>
                        // Panggil fungsi read_message saat halaman dimuat
            $(document).ready(function() {
            $.post("../read_message.php", { user_id: <?= $user_id ?>, seller_id: <?= $seller_id ?> });
        });

    </script>

