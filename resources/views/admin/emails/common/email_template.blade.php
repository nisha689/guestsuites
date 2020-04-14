@inject('helper', 'App\Classes\Helpers\Helper')
<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="50" bgcolor="">
<table width="600" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF">
    <tr>
        <td>
            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td><img src="{{ url('images/emailtop.png') }}"></td>
                </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" height="100"
                   bgcolor="#FFFFFF">
                <tr>
                    <td style="font-size:30px; color:#ef5023; font-family:Arial Black; text-align:center; font-weight:bold; line-height:20px;">{{ $subject }}</td>
                </tr>
            </table>

            <table width="95%" cellpadding="0" cellspacing="0" border="0" align="center" height="15">
                <tr>
                    <td style=" font-size:14px; font-family:Arial; text-align:left; line-height:20px;">
                        {!! $mailContent !!}
                    </td>
                </tr>
            </table>
            <table width="95%" cellpadding="0" cellspacing="0" border="0" align="center" height="80">
                <tr>
                    <td style=" font-size:14px; text-align:left; line-height:20px; margin-top:5px;">
                        <font face="Arial"
                              style="font-size:14px; line-height:20px; text-align:left; color:#203970; font-weight:bold">
                            <br><a href="https://guest-suites.com"> www.guest-suites.com </a>
                            {{--  <br/>{!! Common::getMailPhoneFormat($helper->getPhoneNumber()) !!}--}}
                        </font>
                    </td>
                </tr>
                <tr>
                    <td style=" font-size:14px; color:#000000; font-face:arial; text-align:left; line-height:20px; margin-top:0px;"></td>
                </tr>
            </table>
            <table width="95%" cellpadding="0" cellspacing="0" border="0" align="center" height="50">
                <tbody>
                <tr>
                    <td style=" font-size:12px; text-align:left; line-height:20px; margin-top:5px;"></td>
                    <td style="width:200px;">
                        <a target="_blank" href="{{ $helper->getFacebookUrl() }}"><img
                                    src="{{ url('images/facebook-icon.png') }}" width="29" height="28"></a>
                        <a target="_blank" href="{{ $helper->getTwitterUrl() }}"><img
                                    src="{{ url('images/twitter-icon.png') }}" width="29" height="28"></a>
                        <!--a target="_blank" href="#"><img src="images/google-icon.png" width="29" height="28"></a>
                        <a target="_blank" href="#"><img src="images/pintrest-icon.png" width="29" height="28"></a-->
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td><img src="{{ url('images/emailbottom.png') }}" width="600" height="auto">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
