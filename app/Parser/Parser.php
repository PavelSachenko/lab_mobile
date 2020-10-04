<?php


namespace App\Parser;


class Parser
{
    /**
     * @var IParse
     */
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

    /**
     * @return array
     */
    public function getData(): array
    {
       return $this->parser->run();
    }
}
