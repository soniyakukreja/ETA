<?php //echo $body;  exit; ?>
<html xmlns="">
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#8DC63F" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Creating Email Magic" width="300"  style="display: block;" />
                        </td>
                    </tr><td style="padding: 10px 10px 30px 10px;">
<?php echo $body; ?>                
                    </td><tr>
                        <td style="padding: 30px 30px 30px 30px; background: #8DC63F;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family:Arial,sans-serif; font-size:14px;" width="75%">
                                        Ethical Trade Alliance<br/>
                                        <a href="<?php echo site_url(); ?>" style="color: #ffffff;"><font color="#ffffff">Unsubscribe</font></a> to this newsletter instantly
                                    </td>                                    
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
