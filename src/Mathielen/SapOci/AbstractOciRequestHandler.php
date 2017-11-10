<?php


namespace Mathielen\SapOci;

use Mathielen\SapOci\Exception\OciInvalidRequestException;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractOciRequestHandler implements OciRequestHandlerInterface
{
    abstract protected function validateRequest(Request $request);

    protected function getHookUrlFromRequest(Request $request)
    {
        return $request->get('HOOK_URL');
    }

    public function handle(Request $request)
    {
        $this->validateRequest($request);

        $hookUrl = $this->getHookUrlFromRequest($request);
        if (empty($hookUrl)) {
            throw new OciInvalidRequestException("Parameter HOOK_URL cannot be empty!");
        }

        $request->getSession()->set('oci', [
            'hook' => $hookUrl,
        ]);
    }
}
