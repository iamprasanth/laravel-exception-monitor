<!DOCTYPE>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            body{margin:0;padding:0;min-width:100%!important}.content{width:100%;max-width:600px}
        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <p>
                                    {{__('spt.A new exception occured')}}
                                </p>
                                <br>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <p>
                                    {{__('spt.Exception type')}}: {{get_class($input['exception'])}}
                                </p>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    {{__('spt.Exception message')}}:{{$input['exception']->getMessage()}}
                                </p>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    {{__('spt.Exception details')}}: {{$input['exception']->__tostring()}}
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
