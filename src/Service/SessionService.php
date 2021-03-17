<?php 

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class SessionService
 * @package App\Entity
 * @author Jean Godoy
 * @link https://seidesistemas.com.br
 */

 class SessionService {

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function createSession(string $token)
    {
        $this->session->set('token', $token);
        $token = $this->session->get('token');

        return $token;
    }

    public function getSession()
    {
        $token = $this->session->get('token') ?? null;

        if($token === null || $token === "")
        {
            return false;
        } 

        return $token;
    }

    public function destroy(){
        $this->session->clear();
    }

    public function checked()
    {
        $token = $this->session->get('token') ?? null;
        
        return $token;
    }

 }