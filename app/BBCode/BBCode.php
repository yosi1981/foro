<?php
/**
 * This package is provided by golonka/BBCodeParser
 * https://github.com/golonka/BBCodeParser
 */

namespace App\BBCode;

class BBCode {

    public $parsers = [
        'bold'                 => [
            'pattern' => '/\[b\](.*?)\[\/b\]/s',
            'replace' => '<strong>$1</strong>',
            'content' => '$1',
        ],
        'italic'               => [
            'pattern' => '/\[i\](.*?)\[\/i\]/s',
            'replace' => '<em>$1</em>',
            'content' => '$1',
        ],
        'underline'            => [
            'pattern' => '/\[u\](.*?)\[\/u\]/s',
            'replace' => '<ins>$1</ins>',
            'content' => '$1',
        ],
        'linethrough'          => [
            'pattern' => '/\[s\](.*?)\[\/s\]/s',
            'replace' => '<s>$1</s>',
            'content' => '$1',
        ],
        'size'                 => [
            'pattern' => '/\[size\=([1-7])\](.*?)\[\/size\]/s',
            'replace' => '<font size="$1">$2</font>',
            'content' => '$2',
        ],
        'font'                 => [
            'pattern' => '/\[font\=(.*?)\](.*?)\[\/font\]/s',
            'replace' => '<span style="font-family: $1">$2</span>',
            'content' => '$2',
        ],
        'color'                => [
            'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
            'replace' => '<font color="$1">$2</font>',
            'content' => '$2',
        ],
        'center'               => [
            'pattern' => '/\[center\](.*?)\[\/center\]/s',
            'replace' => '<div style="text-align:center;">$1</div>',
            'content' => '$1',
        ],
        'left'                 => [
            'pattern' => '/\[left\](.*?)\[\/left\]/s',
            'replace' => '<div style="text-align:left;">$1</div>',
            'content' => '$1',
        ],
        'right'                => [
            'pattern' => '/\[right\](.*?)\[\/right\]/s',
            'replace' => '<div style="text-align:right;">$1</div>',
            'content' => '$1',
        ],
        'quote'                => [
            'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
            'replace' => '<blockquote>$1</blockquote>',
            'content' => '$1',
        ],
        'namedquote'           => [
            'pattern' => '/\[quote\=(.*?)\](.*)\[\/quote\]/s',
            'replace' => '<blockquote><span class="help-block padding-0 margin-0"><a href="/">$1</a></span><hr class="margin-0 margin-bottom-10">$2</blockquote>',
            'content' => '$2',
        ],
        'link'                 => [
            'pattern' => '/\[url\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$1</a>',
            'content' => '$1',
        ],
        'namedlink'            => [
            'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
            'replace' => '<a href="$1">$2</a>',
            'content' => '$2',
        ],
        'image'                => [
            'pattern' => '/\[img\](.*?)\[\/img\]/s',
            'replace' => '<img class="img-responsive" src="$1">',
            'content' => '$1',
        ],
        'orderedlistnumerical' => [
            'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
            'replace' => '<ol>$1</ol>',
            'content' => '$1',
        ],
        'orderedlistalpha'     => [
            'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
            'replace' => '<ol type="a">$1</ol>',
            'content' => '$1',
        ],
        'unorderedlist'        => [
            'pattern' => '/\[list\](.*?)\[\/list\]/s',
            'replace' => '<ul>$1</ul>',
            'content' => '$1',
        ],
        'listitem'             => [
            'pattern' => '/\[\*\](.*)/',
            'replace' => '<li>$1</li>',
            'content' => '$1',
        ],
        'code'                 => [
            'pattern' => '/\[code\](.*?)\[\/code\]/s',
            'replace' => '<code>$1</code>',
            'content' => '$1',
        ],
        'youtube'              => [
            'pattern' => '/\[youtube\](.*?)\[\/youtube\]/s',
            'replace' => '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>',
            'content' => '$1',
        ],
        'linebreak'            => [
            'pattern' => '/\r\n/',
            'replace' => '<br>',
            'content' => '',
        ],
    ];

    private $enabledParsers;

    public function __construct()
    {
        $this->enabledParsers = $this->parsers;
    }

    /**
     * Parses the BBCode string
     *
     * @param  string $source String containing the BBCode
     * @return string Parsed string
     */
    public function parse($source, $caseInsensitive = false)
    {
        foreach ($this->enabledParsers as $name => $parser) {
            $pattern = ($caseInsensitive) ? $parser['pattern'] . 'i' : $parser['pattern'];

            $source = $this->searchAndReplace($pattern, $parser['replace'], $source);
        }

        return $source;
    }

    /**
     * Remove all BBCode
     *
     * @param  string $source
     * @return string Parsed text
     */
    public function stripBBCodeTags($source)
    {
        foreach ($this->parsers as $name => $parser) {
            $source = $this->searchAndReplace($parser['pattern'] . 'i', $parser['content'], $source);
        }

        return $source;
    }

    /**
     * Searches after a specified pattern and replaces it with provided structure
     *
     * @param  string $pattern Search pattern
     * @param  string $replace Replacement structure
     * @param  string $source Text to search in
     * @return string Parsed text
     */
    protected function searchAndReplace($pattern, $replace, $source)
    {
        while (preg_match($pattern, $source)) {
            $source = preg_replace($pattern, $replace, $source);
        }

        return $source;
    }

    /**
     * Helper function to parse case sensitive
     *
     * @param  string $source String containing the BBCode
     * @return string Parsed text
     */
    public function parseCaseSensitive($source)
    {
        return $this->parse($source, false);
    }

    /**
     * Helper function to parse case insensitive
     *
     * @param  string $source String containing the BBCode
     * @return string Parsed text
     */
    public function parseCaseInsensitive($source)
    {
        return $this->parse($source, true);
    }

    /**
     * Limits the parsers to only those you specify
     *
     * @param  mixed $only parsers
     * @return object BBCodeParser object
     */
    public function only($only = null)
    {
        $only = (is_array($only)) ? $only : func_get_args();
        $this->enabledParsers = $this->arrayOnly($this->parsers, $only);
        return $this;
    }

    /**
     * Removes the parsers you want to exclude
     *
     * @param  mixed $except parsers
     * @return object BBCodeParser object
     */
    public function except($except = null)
    {
        $except = (is_array($except)) ? $except : func_get_args();
        $this->enabledParsers = $this->arrayExcept($this->parsers, $except);
        return $this;
    }

    /**
     * List of chosen parsers
     *
     * @return array array of parsers
     */
    public function getParsers()
    {
        return $this->enabledParsers;
    }

    /**
     * Sets the parser pattern and replace.
     * This can be used for new parsers or overwriting existing ones.
     *
     * @param string $name Parser name
     * @param string $pattern Pattern
     * @param string $replace Replace pattern
     * @param string $content Parsed text pattern
     * @return void
     */
    public function setParser($name, $pattern, $replace, $content)
    {
        $this->parsers[$name] = array(
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content,
        );

        $this->enabledParsers[$name] = array(
            'pattern' => $pattern,
            'replace' => $replace,
            'content' => $content,
        );
    }

    public $code = [
        'ol'      => 'Ordered List',
        'ul'      => 'Unordered List',
        'b'       => 'Bold',
        'u'       => 'Underline',
        's'       => 'Strike',
        'center'  => 'Align Center',
        'right'   => 'Align Right',
        'sub'     => 'Subscript',
        'sup'     => 'Superscript',
        'justify' => 'Justify',
        'left'    => 'Align Left',
        'font'    => 'Font',
        'color'   => 'Font color',
        'size'    => 'Font size',
        'hr'      => 'Horizontal Ruler',
        'quote'   => 'Quote',
        'code'    => 'Code',
        'youtube' => 'Youtube',
    ];


    /**
     * Filters all parsers that you don't want
     *
     * @param array $parsers An array of all parsers
     * @param array $only Chosen parsers
     * @return array parsers
     */
    private function arrayOnly(array $parsers, $only)
    {
        return array_intersect_key($parsers, array_flip((array)$only));
    }

    /**
     * Removes the parsers that you don't want
     *
     * @param array $parsers An array of all parsers
     * @param array $except Parsers to exclude
     * @return array parsers
     */
    private function arrayExcept(array $parsers, $except)
    {
        return array_diff_key($parsers, array_flip((array)$except));
    }


}