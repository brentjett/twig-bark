<?php

class BRJ_EnqueueTokenParser extends Twig_TokenParser {
    
    function __construct($tag) {
        // This class works for enqueue, register, script, and style tags
        $this->tag = $tag;
    }

    public function parse(Twig_Token $token) {

        $parser = $this->parser;
        $stream = $this->parser->getStream();

        $handle = $stream->expect(Twig_Token::STRING_TYPE)->getValue();
        $path = $stream->expect(Twig_Token::STRING_TYPE)->getValue();
        $pathinfo = pathinfo($path);
        $extension = $pathinfo['extension'];

        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        // @TODO - Figure out what template I'm in to check relative path
        if (!file_exists($path)) {
            if (file_exists(here . $path)) {
                $path = get_stylesheet_directory() . $path;
            }
        }

        if ($this->tag == 'register') {
            $action = 'register';
        } else {
            $action = 'enqueue';
        }
        if ($extension == 'css') {
            $format = 'style';
        } else {
            $format = 'script';
        }
        $function_name = 'wp_' . $action . '_' . $format;
        call_user_func_array($function_name, array($handle, $path));
    }

    public function decideBlockEnd(Twig_Token $token) {
        return $token->test($this->name);
    }

    public function getTag()
    {
        return $this->tag;
    }
} 
?>