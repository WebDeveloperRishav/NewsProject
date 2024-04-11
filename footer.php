<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'admin/config.php';
                $getlogo = "SELECT * FROM settings";
                $logores = mysqli_query($conn, $getlogo);
                if (mysqli_num_rows($logores) > 0) {
                    while ($row1 = mysqli_fetch_assoc($logores)) {

                ?>
                        <span><?php echo $row1['footerdesc']; ?></span>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>

</html>