<?php
namespace Apps\Components\Wallscript\Libraries;

class Link
{

    public function convert($string)
    {
        $string = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $string);
        $string = ' ' . $string;
        $string = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $string);

        $string = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $string);
        $string = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $string);
        $string = substr($string, 1);
		
        return $string;
    }

    function file_get_contents_curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
            $info = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

            //checking mime types
            if(strstr($info,'text/html')) {
                    curl_close($ch);
            return $data;
            } else {
                    return false;
            }
    }

    public function grabSiteInfo($url)
    {
        //fetching url data via curl
        $html = $this->file_get_contents_curl($url);

        //parsing title and description begins here:
        $doc = new \DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');

        //get and display what you need:
        $title = $nodes->item(0)->nodeValue;
        $metas = $doc->getElementsByTagName('meta');
        $description = "";

        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'description')
                $description = $meta->getAttribute('content');
        }

        //fetch images
        $image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
        preg_match_all($image_regex, $html, $img, PREG_PATTERN_ORDER);

        return array('img' => $img[0][0], 'title' => $title, 'description' => $description);

    }

    public function scrapInfo()
    {

    }
}
