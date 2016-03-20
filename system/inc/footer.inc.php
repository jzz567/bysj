<footer>
    <ul>
        <li class="copyright">
            &copy;2016 Jzz
        </li>
        <li>
            <a href="https://51php.org">我的博客</a>
        </li>
    </ul>
</footer>
</body>
<script src="http://jzz15.oss-cn-shenzhen.aliyuncs.com/js/pusher.min.js" type="text/javascript"></script>
<script src="http://jzz15.oss-cn-shenzhen.aliyuncs.com/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var pusher = new Pusher('cea0285687ebb980bc16', {authEndpoint: "<?php echo APP_URI . 'PusherAuth'?>/auth"});
    var channel = pusher.subscribe("<?php echo $channel;?>");
</script>
<script type="text/javascript" src="<?php echo APP_URI; ?>assets/scripts/auth.js"></script>
<?php
if ($class_name != 'User') {
    echo '<script type="text/javascript" src='.APP_URI.'assets/scripts/init.js></script>';
}
?>
</html>