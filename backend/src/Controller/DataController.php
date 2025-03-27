<?php

namespace App\Controller;

use App\Entity\ContactDetails;
use App\Entity\PrimaryData;
use App\Entity\WorkExperience;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DataController
{
  private EntityManagerInterface $em;
  private ValidatorInterface $validator;

  public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
  {
    $this->em = $em;
    $this->validator = $validator;
  }

  #[Route('/api/submit-data', methods: ['POST'])]
  public function submitData(Request $request): JsonResponse
  {
    $data = json_decode($request->getContent(), true);

    $primaryData = new PrimaryData();
    $primaryData->setFirstName($data['primaryData']['firstName'] ?? null);
    $primaryData->setLastName($data['primaryData']['lastName'] ?? null);
    try {
      $birthDateString = $data['primaryData']['birthDate'] ?? null;
  
      if ($birthDateString) {
          $birthDate = DateTimeImmutable::createFromFormat('Y-m-d', $birthDateString);
  
          if (!$birthDate || $birthDate->format('Y-m-d') !== $birthDateString) {
              return new JsonResponse(['message' => 'Invalid birth date format. Use YYYY-MM-DD.'], 400);
          }
  
          $primaryData->setBirthDate($birthDate);
      } else {
          $primaryData->setBirthDate(null);
      }
    } catch (\Exception $e) {
        return new JsonResponse(['message' => 'An error occurred while processing the birth date.'], 400);
    }

    $errors = $this->validator->validate($primaryData);
    if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errorMessages], 400);
    }

    $contactDetails = new ContactDetails();
    $contactDetails->setPhoneNumber($data['contactDetails']['phoneNumber'] ?? null);
    $contactDetails->setEmailAddress($data['contactDetails']['emailAddress'] ?? null);
    $contactDetails->setPrimaryData($primaryData);

    $errors = $this->validator->validate($contactDetails);
    if (count($errors) > 0) {
        $errorMessages = [];
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errorMessages], 400);
    }

    foreach ($data['workExperience'] as $work) {
      $workExperience = new WorkExperience();
      $workExperience->setCompany($work['company'] ?? null);
      $workExperience->setPosition($work['position'] ?? null);
      try {
        $fromDateString = $work['dateFrom'] ?? null;
    
        if ($fromDateString) {
            $fromDate = DateTimeImmutable::createFromFormat('Y-m-d', $fromDateString);
    
            if (!$fromDate || $fromDate->format('Y-m-d') !== $fromDateString) {
                return new JsonResponse(['message' => 'Invalid From date format. Use YYYY-MM-DD.'], 400);
            }
    
            $workExperience->setDateFrom($fromDate);
        } else {
            $workExperience->setDateFrom(null);
        }
      } catch (\Exception $e) {
          return new JsonResponse(['message' => 'An error occurred while processing the birth date.'], 400);
      }
      
      try {
        $toDateString = $work['dateTo'] ?? null;
    
        if ($toDateString) {
            $toDate = DateTimeImmutable::createFromFormat('Y-m-d', $toDateString);
    
            if (!$toDate || $toDate->format('Y-m-d') !== $toDateString) {
                return new JsonResponse(['message' => 'Invalid To date format. Use YYYY-MM-DD.'], 400);
            }
    
            $workExperience->setDateTo($toDate);
        } else {
            $workExperience->setDateTo(null);
        }
      } catch (\Exception $e) {
          return new JsonResponse(['message' => 'An error occurred while processing the birth date.'], 400);
      }

      $workExperience->setPrimaryData($primaryData);
      $errors = $this->validator->validate($workExperience);
      if (count($errors) > 0) {
          $errorMessages = [];
          foreach ($errors as $error) {
              $errorMessages[] = $error->getMessage();
          }

          return new JsonResponse(['errors' => $errorMessages], 400);
      }
      $this->em->persist($workExperience);
    }

    $this->em->persist($primaryData);
    $this->em->persist($contactDetails);
    $this->em->flush();
    
    return new JsonResponse(['id' => $primaryData->getId(), 'message' => 'Data submitted successfully!'], 200);
  }

  #[Route('api/summary/{id}', methods: ['GET'])]
  public function getSummaryData(int $id)
  {
    $primaryData = $this->em->getRepository((PrimaryData::class))->find($id);

    if (!$primaryData) {
      return new JsonResponse(['message' => 'Data not found!'], 404);
    }

    $contactDetails = $primaryData->getContactDetails();
    $workExperiences = $primaryData->getWorkExperiences();

    $response = [
      'primaryData' => [
        'firstName' => $primaryData->getFirstName(),
        'lastName' => $primaryData->getLastName(),
        'birthDate' => $primaryData->getBirthDate()?->format('Y-m-d')
      ],
      'contactDetails' => [
        'phoneNumber' => $contactDetails->getPhoneNumber(),
        'emailAddress' => $contactDetails->getEmailAddress()
      ],
      'workExperience' => array_map(function (WorkExperience $workExperience) {
        return [
          'company' => $workExperience->getCompany(),
          'position' => $workExperience->getPosition(),
          'dateFrom' => $workExperience->getDateFrom()?->format('Y-m-d'),
          'dateTo' => $workExperience->getDateTo()?->format('Y-m-d')
        ];
      }, $workExperiences->toArray()),
    ];

    return new JsonResponse($response, 200);
  }
}