import { ContactDetails, PrimaryData, WorkExperience } from './models';

export type Payload = {
  primaryData: PrimaryData;
  contactDetails: ContactDetails;
  workExperience: WorkExperience[];
}

export type Response = {
  primaryData?: PrimaryData;
  contactDetails?: ContactDetails;
  workExperience?: WorkExperience[];
}