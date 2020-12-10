<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Employees;
use PhpParser\Builder\Function_;

/**
 * @Route("/employees", name="employee_")
 */
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {   
        $employees = $this->getDoctrine()->getRepository(Employees::class)->findAll();
        return $this->json(
            $employees
        );
    }

    /**
     * @Route("/get-id/{id}", name="show", methods={"GET"})
     */
    public function show($id)
    {
        $employee = $this->getDoctrine()->getRepository(Employees::class)->find($id);

        return $this->json(
            $employee
        );
    }

    /**
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create()
    {
        $json = file_get_contents('php://input');
        $data= json_decode($json, true);

        $employee = new Employees();
        $employee->setEmployeeName($data['employee_name']);
        $employee->setPhone($data['phone']);
        $employee->setStreet($data['street']);
        $employee->setCpf($data['cpf']);
        $employee->setRg($data['rg']);
        $employee->setBirthDate(new \DateTime($data['birth_date'], new \DateTimeZone('America/Sao_Paulo')));
        $employee->setCity($data['city']);
        $employee->setUf($data['uf']);
        $employee->setEmail($data['email']);
        $employee->setOffice($data['office']);
        $employee->setSalary($data['salary']);
        $employee->setCreatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
        $employee->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($employee);
        $doctrine->flush();

        return $this->json([
            'data' => 'Funcionario cadastrado com sucesso!'
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT", "PATCH"})
     */
    public function update($id)
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $doctrine = $this->getDoctrine();

        $employee = $doctrine->getRepository(Employees::class)->find($id);

        $employee->setEmployeeName($data['employee_name']);
        $employee->setPhone($data['phone']);
        $employee->setStreet($data['street']);
        $employee->setCpf($data['cpf']);
        $employee->setRg($data['rg']);
        $employee->setBirthDate(new \DateTime($data['birth_date'], new \DateTimeZone('America/Sao_Paulo')));
        $employee->setCity($data['city']);
        $employee->setUf($data['uf']);
        $employee->setEmail($data['email']);
        $employee->setOffice($data['office']);
        $employee->setSalary($data['salary']);
        $employee->setUpdatedAt(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));

        $maneger = $doctrine->getManager();
        $maneger->flush();

        return $this->json([
            'data' => 'Funcionarios atulizadodo com sucesso!'
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete($id)
    {
        $doctrine = $this->getDoctrine();

        $employee = $doctrine->getRepository(Employees::class)->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($employee);
        $manager->flush();

        return $this->json([
            'data' => 'Funcionario deletado com sucesso!'
        ]);

    }
}
