export type PrimaryData = {
  id?: number;
  firstName: string;
  lastName: string;
  birthDate: string;
}

export type ContactDetails = {
  id?: number;
  phoneNumber: string;
  emailAddress: string;
}

export type WorkExperience = {
  id?: number;
  uniqueKey: string;
  company: string,
  position: string,
  dateFrom: string,
  dateTo: string 
};