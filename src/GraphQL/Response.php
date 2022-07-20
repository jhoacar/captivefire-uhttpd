<?php

namespace App\GraphQL;

use GraphQL\GraphQL;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as BaseReponse;
use UciGraphQL\Mutations\Uci\UciMutation;
use UciGraphQL\Providers\UciProvider;
use UciGraphQL\Schema;

/**
 * Class used for response all graphql data.
 */
class Response extends BaseReponse
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var string
     */
    public $uri = '/graphql';

    /**
     * @var string
     */
    public $graphql_method = Request::METHOD_POST;

    /**
     * @param Symfony\Component\HttpFoundation\Request
     * @param array $config
     * @throws \InvalidArgumentException When the HTTP status code is not valid
     */
    public function __construct(Request $request, array $config)
    {
        parent::__construct();
        $this->request = $request;
        foreach ($config as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param void
     * @return bool
     */
    public function isGraphQLRequest(): bool
    {
        return $this->request->getMethod() == $this->graphql_method &&
            $this->request->getPathInfo() === $this->getBaseUrlGraphQL();
    }

    /**
     * @param void
     * @return string
     */
    public function getBaseUrlGraphQl(): string
    {
        $uri = str_starts_with($this->uri, '/') ? $this->uri : '/' . $this->uri;

        return str_ends_with($uri, '/') ? substr($uri, strlen($uri) - 1) : $uri;
    }

    /**
     * Return default 404 error response.
     * @param void
     * @return string
     */
    public function getNotFound(): string
    {
        return json_encode([
            'error' => 'Not found in server',
        ]);
    }

    /**
     * Sends HTTP headers and content.
     * @param UciProvider|null $provider
     * @return $this
     */
    public function sendGraphQL(&$provider = null)
    {
        try {
            if ($this->isGraphQLRequest()) {
                $this->setStatusCode(200)->setContent($this->getContentGraphQL($provider));
            } else {
                $this->setStatusCode(404)->setContent($this->getNotFound());
            }
        } catch (\Throwable $error) {
            $this->setContent(json_encode(['error' => $error->getMessage()]));
        } finally {
            $this->setJsonHeaders();
            $this->setCorsHeaders();

            return parent::send();
        }
    }

    /**
     * Load Json Response.
     * @param void
     * @return void
     */
    private function setJsonHeaders()
    {
        $this->headers->set('Cache-Control', 'no-cache');
        $this->headers->set('Content-Type', 'application/json');
    }

    /**
     * Load the CORS policy.
     * @param void
     * @return void
     */
    private function setCorsHeaders()
    {
        /* CORS Policy */
        $this->headers->set('Access-Control-Allow-Origin', '*');
        $this->headers->set('Access-Control-Allow-Methods', '*');
    }

    /**
     * Execute Query for GraphQL.
     * @param UciProvider|null $provider
     * @return string
     */
    public function getContentGraphQL(&$provider = null): string
    {
        // Prepare context that will be available in all field resolvers (as 3rd argument):
        $appContext = new Context();
        $appContext->request = $this->request;

        $input = $this->request->toArray();
        $query = $input[array_key_first($input)];

        $provider = UciMutation::uci()->getProvider();
        $result = GraphQL::executeQuery(
            Schema::get(),
            $query,
            null,
            $appContext,
            (array) $input['variables']
        );
        $output = $result->toArray();

        return json_encode($output);
    }
}
