</body>
</html><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyOSIS Vote - Konfirmasi</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #d1d1d1; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .outer-container {
            background-color: #ffffff;
            width: 95%;
            max-width: 900px;
            height: 550px;
            margin: auto;
            position: relative;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
        }

        .header-top {
            width: 100%;
            margin-bottom: 20px;
        }
        .logo-myosis span {
            font-weight: 600;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .logo-myosis img{
            width:90px;
            height: auto;
            
            }
        .logo-myosis {
            position: absolute;
            top: 20px;
            left: 20px;
            
             
            font-weight: bold;
            font-size: 22px;
            color: #000000;
        }
        .logo-sekolah img{
            width:70px;
            height: auto;
            }
        .logo-sekolah {
            position: absolute;
            top: 20px;
            right: 20px;
            margin-top: 20px;
        }
        .inner-card {
            background-color: #ffffff;
            width: 380px;
            margin: auto; 
            padding: 30px;
            border-radius: 10px;
        box-shadow:0 4px 12px rgba(0,0,0,0.2);
            text-align: center;
        }
        .check-circle {
            width: 75px;
            height: 75px;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;
            font-size: 35px;
        }

        h2 {
            color: #3b5998;
            font-size: 20px;
            margin: 10px 0;
        }

        .desc-text {
            font-size: 12.5px;
            color: #000000;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .desc-text span {
            color: #264EC5
        }
        .paslon-box {
            margin-bottom: 20px;
        }

        .user-square {
            background-color: #3b5998;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 8px;
            font-size: 16px;
        }

        .paslon-box p {
            font-size: 10px;
            color: #315ABF;
            margin: 0;
        }

        .paslon-name {
            font-weight: bold;
            font-size: 13px;
            color: #315ABF;
            margin-top: 4px;
        }

        .btn-blue {
            background-color: #3b5998;
            color: white;
            text-decoration: none;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .header1{
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

    <div class="outer-container">
        <span style="font-size: 22px; font-weight: bold;">MyOSIS Vote</span>

        <div class="header-top">
            <div class="header1">
                <img src="myosis5.png" alt="Logo" class="img-logo"><br>
            </div>
            
            <div class="logo-sekolah">
                <img src="logo-removebg-preview (1).png" alt="Logo Sekolah" class="img-sekolah">
            </div>
        </div>

        <div class="inner-card">
            <div class="check-circle">
              <img src="centang.jpeg" alt="Check" style="width: 50px; height: 50px;">
            </div>

            <h2>Vote Berhasil</h2>

            <p class="desc-text">
                Terimakasih telah berpartisipasi dalam pemilihan.<br>
                Suara Anda telah tercatat dan <span>tidak dapat diubah</span>
            </p>

            <div class="paslon-box">
                <div class="user-square">
                    <i class="fa-solid fa-user"></i>
                </div>
                <p>Anda memilih kandidat:</p>
                <div class="paslon-name">
                    <?php echo "PASLON TIGA"; ?>
                </div>
            </div>

            <a href="#" class="btn-blue">
                <i class="fa-solid fa-arrow-left" style="font-size: 9px;"></i> Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>