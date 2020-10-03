<?php


namespace App\Parser;


class Parser
{
    private IParse $parser;

    /**
     * Parser constructor.
     * @param IParse $parser
     */
    public function __construct(IParse $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param IParse $parser
     */
    public function setParser(IParse $parser): void
    {
        $this->parser = $parser;
    }

    public function getData(): array
    {
       return $this->parser->run();
    }
}
