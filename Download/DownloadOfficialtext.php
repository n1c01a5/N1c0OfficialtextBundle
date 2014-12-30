<?php

namespace N1c0\OfficialtextBundle\Download;

use Pandoc\Pandoc;

class DownloadOfficialtext
{
    private $appOfficialtext;

    public function __construct($appOfficialtext)
    {
        $this->appOfficialtext = $appOfficialtext;
    }

    public function getConvert($id, $format)
    {
        $pandoc = new Pandoc();

        $officialtext = $this->appOfficialtext->findOfficialtextById($id);

        $raw = '%'.$officialtext->getTitle();
        $raw .= "\r\n";
        $raw .= '%'.$officialtext->getAuthorsrc();

        $raw .= "\r\n";
        $raw .= '%'.$officialtext->getCreatedAt()->format("m M Y");
        $raw .= "\r\n";
        $raw .= $officialtext->getBody();

        $options = array(
            "latex-engine" => "xelatex",
            "from"         => "markdown_mmd",
            "to"           => $format,
        );

        return $pandoc->runWith($raw, $options);
    }
}
