<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\Atelier;
use App\Entity\Vacation;
use App\Form\VacationFormType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;

class VacationFormTypeTest extends TypeTestCase
{
    private Atelier $unAtelier;
    private DateTime $dateDuJour;
    private DateTime $dateDepart;
    private EntityManager $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->unAtelier = $this->createMock(Atelier::class);
        $this->dateDuJour = new DateTime();
        $this->dateDepart = $this->dateDuJour->modify('-1 day');
        $this->em = $this->createMock(EntityManager::class);
    }

    /**
     * Teste la création du formulaire.
     *
     * @return Form
     */
    public function testCreationForm(): Form
    {
        $model = new Vacation();

        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(VacationFormType::class, $model);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        return $form;
    }

    /**
     * Teste la soumission d'un formulaire valide.
     *
     * @depends testCreationForm
     * @return Vacation
     */
    public function testSubmitValidData(Form $form)
    {
        $formData = [
            'dateheureDebut' => $this->dateDepart,
            'dateheureFin' => $this->dateDuJour,
            'atelier' => $this->unAtelier,
        ];

        $expected = new Vacation();
        $expected->setDateheureDebut($this->dateDepart);
        $expected->setDateheureFin($this->dateDuJour);
        $expected->setAtelier($this->unAtelier);

        // submit the data to the form directly
        $form->submit($formData);

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $form->getData());
        
        return $form->getData();
    }

    /**
     * Teste la modification d'un formulaire.
     *
     * @depends testSubmitValidData
     * @param Vacation $vacation
     * @return void
     */
    public function testModifyVacationForm(Vacation $vacation)
    {
        $ancienneVacation = clone $vacation;
        $form = $this->factory->create(VacationFormType::class, $vacation);

        $formData = [
            'dateheureDebut' => new DateTime(),
            'dateheureFin' => $this->dateDepart->modify('-1 year'),
            'atelier' => $this->unAtelier,
        ];

        $form->submit($formData);

        $this->assertNotEquals($ancienneVacation, $form->getData());
    }	
}
