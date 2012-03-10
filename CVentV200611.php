<?php
class Retrieve {
  public $ObjectType; // CvObjectType
  public $Ids; // IdArray
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class RetrieveResponse {
  public $RetrieveResult; // RetrieveResult
}

class CventSessionHeader {
  public $CventSessionValue; // string
}

class GetUpdated {
  public $ObjectType; // CvObjectType
  public $StartDate; // dateTime
  public $EndDate; // dateTime
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class GetUpdatedResponse {
  public $GetUpdatedResult; // GetUpdatedResult
}

class Search {
  public $ObjectType; // CvObjectType
  public $CvSearchObject; // CvSearch
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class SearchResponse {
  public $SearchResult; // SearchResult
}

class DescribeGlobal {
}

class DescribeGlobalResponse {
  public $DescribeGlobalResult; // DescribeGlobalResult
}

class DescribeCvObject {
  public $ObjectTypes; // CvObjectTypeArray
}

class DescribeCvObjectResponse {
  public $DescribeCvObjectResult; // DescribeCvObjectResults
}

class Login {
  public $AccountNumber; // string
  public $UserName; // string
  public $Password; // string

  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class LoginResponse {
  public $LoginResult; // LoginResult
}

class CreateContact {
  public $Contacts; // ArrayOfContact
}

class CreateContactResponse {
  public $CreateContactResult; // CreateContactResultArray
}

class UpdateContact {
  public $Contacts; // ArrayOfContact
}

class UpdateContactResponse {
  public $UpdateContactResult; // UpdateContactResultArray
}

class UpdateInviteeInternalInfo {
  public $EventId; // string
  public $CvAnswers; // ArrayOfCvAnswer
}

class UpdateInviteeInternalInfoResponse {
  public $UpdateInviteeInternalInfoResult; // UpdateInviteeInternalInfoResultArray
}

class DeleteContact {
  public $CvObjects; // ArrayOfCvObject
}

class DeleteContactResponse {
  public $DeleteContactResult; // DeleteContactResultArray
}

class ManageContactGroupMembers {
  public $Action; // ManageGroupAction
  public $GroupId; // string
  public $CvObjects; // CvObjectArray
}

class ManageContactGroupMembersResponse {
  public $ManageContactGroupMembersResult; // ManageContactGroupMembersResultArray
}

class CreateContactGroup {
  public $ContactGroups; // ArrayOfContactGroup
}

class CreateContactGroupResponse {
  public $CreateContactGroupResult; // CreateContactGroupResultArray
}

class TransferInvitee {
  public $ActivityType; // ActivityType
  public $ActivityId; // string
  public $CvObjects; // CvObjectArray
}

class TransferInviteeResponse {
  public $TransferInviteeResult; // TransferInviteeResultArray
}

class CheckIn {
  public $CvObjects; // ArrayOfCvObject
  public $AttendeeType; // string
  public $ProductId; // string
}

class CheckInResponse {
  public $CheckInResult; // CheckInResultArray
}

class SimpleEventRegistration {
  public $CvObjects; // ArrayOfCvObject
  public $RegAction; // RegistrationAction
  public $EventId; // string
}

class SimpleEventRegistrationResponse {
  public $SimpleEventRegistrationResult; // SimpleEventRegistrationResultArray
}

class SendEmail {
  public $EmailRequest; // SendEmailRequest
}

class SendEmailResponse {
  public $SendEmailResult; // SendEmailResultArray
}

class CreateUser {
  public $Users; // ArrayOfUser
}

class CreateUserResponse {
  public $CreateUserResult; // CreateUserResultArray
}

class UpdateUser {
  public $Users; // ArrayOfUser
}

class UpdateUserResponse {
  public $UpdateUserResult; // UpdateUserResultArray
}

class DeleteUser {
  public $CvObjects; // ArrayOfCvObject
}

class DeleteUserResponse {
  public $DeleteUserResult; // DeleteUserResultArray
}

class ManageUserGroup {
  public $Action; // ManageGroupAction
  public $GroupId; // string
  public $CvObjects; // CvObjectArray
}

class ManageUserGroupResponse {
  public $ManageUserGroupResult; // ManageUserGroupResultArray
}

class CreateNoRegEvent {
  public $EventParameters; // ArrayOfEventParameters
}

class CreateNoRegEventResponse {
  public $CreateNoRegEventResult; // CreateNoRegEventResultArray
}

class CreateRateHistory {
  public $RateHistoryArray; // ArrayOfRateHistory
}

class CreateRateHistoryResponse {
  public $CreateRateHistoryResult; // CreateRateHistoryResultArray
}

class DeleteRateHistory {
  public $CvObjects; // ArrayOfCvObject
}

class DeleteRateHistoryResponse {
  public $DeleteRateHistoryResult; // DeleteRateHistoryResultArray
}

class CreateTransaction {
  public $Transactions; // ArrayOfTransaction
  public $EventId; // string
}

class CreateTransactionResponse {
  public $CreateTransactionResult; // CreateTransactionResultArray
}

class CvObjectType {
  const Contact = 'Contact';
  const Event = 'Event';
  const Invitee = 'Invitee';
  const Registration = 'Registration';
  const Respondent = 'Respondent';
  const Response = 'Response';
  const Survey = 'Survey';
  const Transaction = 'Transaction';
  const Travel = 'Travel';
  const ContactGroup = 'ContactGroup';
  const EventEmailHistory = 'EventEmailHistory';
  const Budget = 'Budget';
  const BudgetItem = 'BudgetItem';
  const User = 'User';
  const UserGroup = 'UserGroup';
  const UserRole = 'UserRole';
  const MeetingRequestUser = 'MeetingRequestUser';
  const RFP = 'RFP';
  const Proposal = 'Proposal';
  const SupplierRFP = 'SupplierRFP';
  const SupplierProposal = 'SupplierProposal';
  const RateHistory = 'RateHistory';
  const EventQuestion = 'EventQuestion';
  const SurveyEmailHistory = 'SurveyEmailHistory';
  const Supplier = 'Supplier';
}

class IdArray {
  public $Id; // string
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class RetrieveResult {
  public $CvObject; // CvObject
}

class CvObject {
  public $Id; // string
  public $MessageId; // string
}

class BudgetItem {
  public $CostDetail; // CostDetail
  public $SavingsDetail; // SavingsDetail
  public $BudgetPaymentDetail; // BudgetPaymentDetail
  public $ItemName; // string
  public $ItemCode; // string
  public $ItemType; // string
  public $EventId; // string
  public $EventCode; // string
  public $RFPId; // string
  public $RFPCode; // string
  public $CategoryName; // string
  public $SubCategoryId; // string
  public $SubCategoryName; // string
  public $Status; // string
  public $ProductId; // string
  public $ProductName; // string
  public $VendorId; // string
  public $VendorName; // string
  public $GLName; // string
  public $GLCode; // string
  public $TaxOnGratuity; // string
  public $CostAvoidance; // string
  public $AvoidanceDescription; // string
  public $InternalNote; // string
  public $LastModifiedDate; // string
  public $ItemDate; // dateTime
}

class CostDetail {
  public $CostDetailId; // string
  public $CostName; // string
  public $Units; // int
  public $Cost; // decimal
  public $Tax; // decimal
  public $TaxType; // string
  public $Tax2; // decimal
  public $Tax2Type; // string
  public $Tax3; // decimal
  public $Tax3Type; // string
  public $Tax4; // decimal
  public $Tax4Type; // string
  public $Tax5; // decimal
  public $Tax5Type; // string
  public $Gratuity; // decimal
  public $GratuityType; // string
}

class SavingsDetail {
  public $SavingsDetailId; // string
  public $SavingsName; // string
  public $Amount; // decimal
}

class BudgetPaymentDetail {
  public $PaymentDetailId; // string
  public $PaymentName; // string
  public $PaymentType; // string
  public $PaymentDate; // dateTime
  public $Amount; // decimal
  public $ReferenceNumber; // string
}

class Budget {
  public $CategoryDetail; // CategoryDetail
  public $EventCode; // string
  public $EventTitle; // string
  public $DefaultTax; // decimal
  public $DefaultTaxType; // string
  public $DefaultTax2; // decimal
  public $DefaultTax2Type; // string
  public $DefaultTax3; // decimal
  public $DefaultTax3Type; // string
  public $DefaultTax4; // decimal
  public $DefaultTax4Type; // string
  public $DefaultTax5; // decimal
  public $DefaultTax5Type; // string
  public $DefaultGratuity; // decimal
  public $DefaultGratuityType; // string
  public $ModifiedBy; // string
  public $LastModifiedDate; // dateTime
  public $Currency; // string
}

class CategoryDetail {
  public $AmountDetail; // AmountDetail
  public $CategoryName; // string
  public $HighLevelEstimate; // decimal
}

class AmountDetail {
  public $AmountDetailId; // string
  public $AmountName; // string
  public $Amount; // decimal
}

class EventParameters {
  public $CustomFieldDetail; // CustomFieldDetail
  public $Title; // string
  public $Description; // string
  public $Capacity; // int
  public $LocationName; // string
  public $Address1; // string
  public $Address2; // string
  public $Address3; // string
  public $City; // string
  public $StateCode; // string
  public $PostalCode; // string
  public $CountryCode; // string
  public $Phone; // string
  public $TimeZoneCode; // string
  public $StartDate; // dateTime
  public $EndDate; // dateTime
  public $PlannerFirstName; // string
  public $PlannerLastName; // string
}

class CustomFieldDetail {
  public $FieldName; // string
  public $FieldType; // string
  public $FieldValue; // string
  public $FieldId; // string
}

class EventQuestion {
  public $AnswerDetail; // AnswerDetail
  public $RowDetail; // RowDetail
  public $QuestionText; // string
  public $QuestionCode; // string
  public $SurveyType; // string
  public $QuestionType; // string
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $ProductName; // string
  public $ProductId; // string
  public $InternalNote; // string
  public $AllowOther; // boolean
  public $OtherLabel; // string
  public $LastModifiedDate; // dateTime
}

class AnswerDetail {
  public $AnswerText; // string
}

class RowDetail {
  public $RowText; // string
}

class EventEmailHistory {
  public $EventId; // string
  public $InviteeId; // string
  public $ContactId; // string
  public $TargetList; // string
  public $EmailSentDate; // dateTime
  public $EmailStatus; // string
  public $EmailType; // string
  public $FromEmailAddress; // string
  public $ToEmailAddress; // string
  public $EmailViewed; // boolean
  public $EmailBounced; // boolean
  public $LastModifiedDate; // dateTime
}

class UserRole {
  public $UserRights; // UserRights
  public $UserRoleName; // string
  public $Description; // string
}

class UserRights {
  public $UserRightName; // string
  public $UserRightCategory; // string
  public $AccessLevel; // string
}

class Contact {
  public $CustomFieldDetail; // CustomFieldDetail
  public $ContactGroupDetail; // ContactGroupDetail
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $EmailAddress; // string
  public $CCEmailAddress; // string
  public $Active; // boolean
  public $Company; // string
  public $Title; // string
  public $ContactType; // string
  public $ContactTypeCode; // string
  public $Salutation; // string
  public $Nickname; // string
  public $MiddleName; // string
  public $Designation; // string
  public $ExcludedFromEmail; // boolean
  public $LastOptOutBy; // string
  public $LastOptOutDate; // dateTime
  public $CreatedDate; // dateTime
  public $CreatedBy; // string
  public $LastModifiedDate; // dateTime
  public $LastModifiedBy; // string
  public $EmailAddressStatus; // string
  public $LogDate; // dateTime
  public $LogReason; // string
  public $LogResponse; // string
  public $PrimaryAddressType; // PrimaryAddressType
  public $HomeAddress1; // string
  public $HomeAddress2; // string
  public $HomeAddress3; // string
  public $HomeCity; // string
  public $HomeState; // string
  public $HomeStateCode; // string
  public $HomePostalCode; // string
  public $HomeCountry; // string
  public $HomeCountryCode; // string
  public $HomePhone; // string
  public $HomeFax; // string
  public $WorkAddress1; // string
  public $WorkAddress2; // string
  public $WorkAddress3; // string
  public $WorkCity; // string
  public $WorkState; // string
  public $WorkStateCode; // string
  public $WorkPostalCode; // string
  public $WorkCountry; // string
  public $WorkCountryCode; // string
  public $WorkPhone; // string
  public $WorkFax; // string
  public $MobilePhone; // string
  public $Pager; // string
  public $OptedIn; // boolean
}

class ContactGroupDetail {
  public $GroupName; // string
  public $GroupId; // string
}

class PrimaryAddressType {
  const Work = 'Work';
  const Home = 'Home';
}

class ContactGroup {
  public $Name; // string
  public $ShortDescription; // string
}

class User {
  public $UserGroupDetail; // UserGroupDetail
  public $VisibilityDefaults; // VisibilityDefaults
  public $Active; // boolean
  public $Address1; // string
  public $Address2; // string
  public $Address3; // string
  public $AllEventVisibility; // boolean
  public $AllRFPVisibility; // boolean
  public $AllSurveyVisibility; // boolean
  public $ChangePasswordOnLogin; // boolean
  public $City; // string
  public $Company; // string
  public $Country; // string
  public $CountryCode; // string
  public $CreatedBy; // string
  public $CreatedDate; // dateTime
  public $DefaultContactGroupId; // string
  public $Email; // string
  public $FederatedId; // string
  public $FirstName; // string
  public $HomeFax; // string
  public $HomePhone; // string
  public $LastModifiedBy; // string
  public $LastModifiedDate; // string
  public $LastName; // string
  public $MobilePhone; // string
  public $Pager; // string
  public $Password; // string
  public $PostalCode; // string
  public $Prefix; // string
  public $State; // string
  public $StateCode; // string
  public $Title; // string
  public $Username; // string
  public $UserType; // CvUserType
  public $UserRole; // string
  public $UserRoleId; // string
  public $WorkFax; // string
  public $WorkPhone; // string
}

class UserGroupDetail {
  public $UserGroupName; // string
  public $UserGroupId; // string
}

class VisibilityDefaults {
  public $UserGroupName; // string
  public $VisibilityType; // CvVisibilityType
  public $UserGroupId; // string
}

class CvVisibilityType {
  const Event = 'Event';
  const Survey = 'Survey';
  const RFP = 'RFP';
}

class CvUserType {
  const Application = 'Application';
  const Requester = 'Requester';
}

class MeetingRequestUser {
  public $Active; // string
  public $Address1; // string
  public $Address2; // string
  public $Address3; // string
  public $ChangePasswordOnLogin; // boolean
  public $City; // string
  public $Company; // string
  public $Country; // string
  public $CountryCode; // string
  public $CreatedBy; // string
  public $CreatedDate; // dateTime
  public $Email; // string
  public $FederatedId; // string
  public $FirstName; // string
  public $HomeFax; // string
  public $HomePhone; // string
  public $LastModifiedBy; // string
  public $LastModifiedDate; // string
  public $LastName; // string
  public $MobilePhone; // string
  public $Pager; // string
  public $Password; // string
  public $PostalCode; // string
  public $Prefix; // string
  public $State; // string
  public $StateCode; // string
  public $Title; // string
  public $Username; // string
  public $WorkFax; // string
  public $WorkPhone; // string
}

class UserGroup {
  public $UserGroupName; // string
  public $InternalNote; // string
}

class Travel {
  public $HotelRequest; // HotelRequest
  public $CarRequest; // CarRequest
  public $AirRequest; // AirRequest
  public $AirActual; // AirActual
  public $ContactId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $CCEmailAddress; // string
  public $WorkPhone; // string
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $EventStartDate; // dateTime
  public $Status; // string
  public $RegistrationType; // string
}

class HotelRequest {
  public $TravelSurveyDetail; // TravelSurveyDetail
  public $RequesterFirstName; // string
  public $RequesterLastName; // string
  public $HotelName; // string
  public $HotelCode; // string
  public $RoomName; // string
  public $RoomCode; // string
  public $Quantity; // string
  public $RoommateRequest; // string
  public $SpecialNeeds; // string
  public $RewardsCode; // string
  public $CheckinDate; // dateTime
  public $CheckoutDate; // dateTime
  public $Smoking; // boolean
  public $Cancelled; // boolean
  public $Status; // string
  public $ConfirmationNumber; // string
  public $Handicap; // boolean
}

class TravelSurveyDetail {
  public $Answer; // TravelAnswer
  public $SurveyType; // string
  public $QuestionId; // string
  public $QuestionCode; // string
  public $QuestionText; // string
}

class TravelAnswer {
  public $AnswerPart; // string
  public $AnswerColumn; // string
  public $AnswerText; // string
  public $AnswerOther; // string
  public $AnswerComment; // string
}

class CarRequest {
  public $TravelSurveyDetail; // TravelSurveyDetail
  public $RequestId; // string
  public $RequesterFirstName; // string
  public $RequesterLastName; // string
  public $PickUpDate; // dateTime
  public $PickUpTime; // string
  public $DropOffDate; // dateTime
  public $DropOffTime; // string
  public $RentalCarType; // string
  public $RentalCarCompany; // string
  public $RewardsCode; // string
  public $Cancelled; // boolean
  public $Status; // string
  public $ConfirmationNumber; // string
}

class AirRequest {
  public $TravelSurveyDetail; // TravelSurveyDetail
  public $RequesterFirstName; // string
  public $RequesterLastName; // string
  public $Leg1Origin; // string
  public $Leg1Destination; // string
  public $Leg1Date; // dateTime
  public $Leg1Time; // string
  public $Leg2Origin; // string
  public $Leg2Destination; // string
  public $Leg2Date; // dateTime
  public $Leg2Time; // string
  public $TicketType; // string
  public $SeatType; // string
  public $MealText; // string
  public $OtherText; // string
  public $RewardsCode1; // string
  public $RewardsCode2; // string
  public $RewardsCode3; // string
  public $AirlinePreference1; // string
  public $AirlinePreference2; // string
  public $AirlinePreference3; // string
  public $AgeCategory; // string
  public $Cancelled; // boolean
  public $Status; // string
  public $PlannerMemo; // string
  public $FullName; // string
  public $DateOfBirth; // string
  public $Gender; // string
}

class AirActual {
  public $FlightDetail; // FlightDetail
  public $Name; // string
  public $ConfirmationNumber; // string
  public $TotalAmount; // string
  public $CurrencyCode; // string
  public $Note; // string
  public $GDSRecordLocator; // string
  public $GDSNote; // string
}

class FlightDetail {
  public $Airline; // string
  public $FlightNumber; // string
  public $Origin; // string
  public $Destination; // string
  public $Arriving; // dateTime
  public $Departing; // dateTime
  public $SeatNumber; // string
  public $TicketClass; // string
}

class Survey {
  public $CustomFieldDetail; // CustomFieldDetail
  public $WeblinkDetail; // WeblinkDetail
  public $SurveyCode; // string
  public $SurveyTitle; // string
  public $SurveyCloseDate; // dateTime
  public $Description; // string
  public $SurveyStatus; // string
  public $InternalNote; // string
  public $PlannerFirstName; // string
  public $PlannerLastName; // string
  public $SurveyLaunchDate; // dateTime
}

class WeblinkDetail {
  public $Target; // string
  public $URL; // string
}

class Response {
  public $SurveyDetail; // ResponseSurveyDetail
  public $ContactId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $WorkPhone; // string
  public $SurveyId; // string
  public $SurveyCode; // string
  public $SurveyTitle; // string
  public $SurveyLaunchDate; // dateTime
  public $Status; // string
  public $InternalNote; // string
  public $InvitedBy; // string
  public $CompletionDate; // dateTime
  public $LastModifiedDate; // dateTime
  public $ModifiedBy; // string
  public $ResponseMethod; // string
  public $ResponseNumber; // long
}

class ResponseSurveyDetail {
  public $QuestionCode; // string
}

class SurveyDetail {
  public $QuestionText; // string
  public $QuestionExportValue; // string
  public $QuestionType; // int
  public $Answer; // Answer
  public $QuestionScore; // decimal
}

class Answer {
  public $AnswerPart; // string
  public $AnswerColumn; // string
  public $AnswerText; // string
  public $AnswerOther; // string
  public $AnswerExportValue; // string
  public $AnswerComment; // string
}

class SurveyEmailHistory {
  public $SurveyId; // string
  public $RespondentId; // string
  public $ContactId; // string
  public $TargetList; // string
  public $EmailSentDate; // dateTime
  public $EmailStatus; // string
  public $EmailType; // string
  public $FromEmailAddress; // string
  public $ToEmailAddress; // string
  public $EmailViewed; // boolean
  public $EmailBounced; // boolean
  public $LastModifiedDate; // dateTime
}

class RFP {
  public $EventInfo; // RFPEventInfo
  public $OrganizationInfo; // RFPOrganizationInfo
  public $KeyContactInfo; // RFPKeyContactInfo
  public $EventRequirementInfo; // RFPEventRequirementInfo
  public $SleepRoomInfo; // RFPSleepRoomInfo
  public $AttachmentDetail; // RFPAttachmentDetail
  public $QuestionDetail; // RFPQuestionDetail
  public $DinnerInfo; // RFPDinnerInfo
  public $SupplierDetail; // RFPSupplierDetail
  public $UserVisibilityDetail; // UserDetail
  public $UserGroupVisibilityDetail; // UserGroupDetail
  public $RFPType; // string
  public $RFPStatus; // string
  public $RFPCode; // string
  public $RFPName; // string
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $ResponseDueDate; // dateTime
  public $DecisionDate; // dateTime
  public $AwardedDate; // dateTime
  public $CancelledDate; // dateTime
  public $Currency; // string
  public $RFPDescription; // string
  public $DecisionFactors; // string
  public $Commissionable; // boolean
  public $CommissionRate; // integer
  public $InternalNote; // string
  public $CreatedDate; // dateTime
  public $Archived; // boolean
  public $CreatedBy; // string
  public $LastModifiedDate; // dateTime
  public $LastModifiedBy; // string
  public $QuickRFP; // boolean
}

class RFPEventInfo {
  public $EventHistoryDetail; // RFPEventHistoryDetail
}

class BaseRFPEventInfo {
  public $EventName; // string
  public $EventType; // string
  public $ReferenceNumber; // string
  public $EventStartDate; // dateTime
  public $EventEndDate; // dateTime
  public $TotalAttendees; // integer
  public $RepeatEvent; // boolean
  public $TotalBudget; // decimal
  public $TotalMeetingSpace; // integer
  public $AlternateStartDate1; // dateTime
  public $AlternateEndDate1; // dateTime
  public $AlternateStartDate2; // dateTime
  public $AlternateEndDate2; // dateTime
  public $LargestMeetingRoom; // integer
  public $ContractSignatureLocation; // string
  public $BusinessObjectives; // string
  public $DestinationsUnderConsideration; // string
  public $AdditionalInformation; // string
  public $Concessions; // string
  public $BillingInformation; // string
  public $FlexibleDates; // boolean
}

class SupplierRFPEventInfo {
  public $EventHistoryDetail; // SupplierRFPEventHistoryDetail
}

class SupplierRFPEventHistoryDetail {
}

class BaseRFPEventHistoryDetail {
  public $VenueName; // string
  public $City; // string
  public $State; // string
  public $StateCode; // string
  public $Date; // string
  public $Attendees; // integer
  public $RoomBlock; // integer
  public $RoomPickup; // integer
}

class RFPEventHistoryDetail {
  public $EventHistoryNote; // string
  public $FoodAndBeverageSpend; // string
}

class RFPOrganizationInfo {
  public $Organization; // string
  public $OrganizationType; // string
  public $OrganizationAddress1; // string
  public $OrganizationAddress2; // string
  public $OrganizationAddress3; // string
  public $OrganizationCity; // string
  public $OrganizationState; // string
  public $OrganizationStateCode; // string
  public $OrganizationPostalCode; // string
  public $OrganizationCountry; // string
  public $OrganizationCountryCode; // string
  public $Employees; // integer
  public $EventsPerYear; // integer
  public $SingleDayEvents; // string
  public $MultiDayEvents; // string
  public $AverageAttendeesPerEvent; // integer
  public $AverageRoomNightsPerEvent; // integer
  public $TotalAttendeesPerYear; // integer
  public $TotalRoomNightsPerYear; // integer
  public $OrganizationInformation; // string
}

class RFPKeyContactInfo {
}

class KeyContactInfo {
  public $KeyContactFirstName; // string
  public $KeyContactLastName; // string
  public $KeyContactTitle; // string
  public $KeyContactEmailAddress; // string
  public $KeyContactPhone; // string
  public $KeyContactFax; // string
  public $KeyContactMobilePhone; // string
  public $KeyContactOrganization; // string
  public $KeyContactOrganizationWebsite; // string
  public $KeyContactAddress1; // string
  public $KeyContactAddress2; // string
  public $KeyContactAddress3; // string
  public $KeyContactCity; // string
  public $KeyContactState; // string
  public $KeyContactStateCode; // string
  public $KeyContactPostalCode; // string
  public $KeyContactCountry; // string
  public $KeyContactCountryCode; // string
  public $KeyContactAdditionalInformation; // string
}

class ProposalKeyContactInfo {
}

class RFPEventRequirementInfo {
  public $MeetingRoomDetail; // RFPMeetingRoomDetail
  public $FoodAndBeverageBudget; // double
  public $TotalMeetingRooms; // integer
  public $MeetingRoomSizeType; // string
  public $MeetingRoomAdditionalInformation; // string
  public $AmenityAdditionalInformation; // string
}

class RFPMeetingRoomDetail {
  public $DayNumber; // integer
  public $StartTime; // dateTime
  public $EndTime; // dateTime
  public $AgendaItem; // string
  public $AgendaItemType; // string
  public $SetupType; // string
  public $RoomSize; // integer
  public $NumberOfPeople; // integer
  public $TwentyFourHourHold; // boolean
  public $MeetingRoomNote; // string
}

class RFPSleepRoomInfo {
  public $SleepRoomDetail; // RFPSleepRoomDetail
  public $OccupancyPerRoomDetail; // RFPOccupancyPerRoomDetail
  public $CheckInDate; // dateTime
  public $BudgetedRoomRate; // double
  public $SleepRoomAdditionalInformation; // string
}

class RFPSleepRoomDetail {
  public $DayNumber; // integer
  public $Date; // dateTime
  public $AnyRoomQuantity; // integer
  public $SingleRoomQuantity; // integer
  public $DoubleRoomQuantity; // integer
  public $SuiteQuantity; // integer
  public $SleepRoomNote; // string
}

class RFPOccupancyPerRoomDetail {
  public $RoomType; // string
  public $Occupancy; // string
}

class RFPAttachmentDetail {
}

class AttachmentDetail {
  public $FileName; // string
  public $FileType; // string
  public $FileSize; // integer
  public $UploadedDate; // dateTime
  public $FileUrl; // string
}

class ProposalAttachmentDetail {
}

class RFPQuestionDetail {
  public $QuestionId; // string
  public $QuestionType; // string
  public $QuestionText; // string
}

class ProposalSurveyDetail {
  public $Answer; // ProposalAnswer
}

class ProposalAnswer {
  public $AnswerPart; // string
  public $AnswerColumn; // string
  public $AnswerText; // string
  public $AnswerOther; // string
  public $AnswerComment; // string
}

class RFPDinnerInfo {
  public $DinnerStartDate; // dateTime
  public $DinnerEndDate; // dateTime
  public $DinnerAttendees; // integer
  public $DinnerFoodAndBeverage; // decimal
  public $DinnerContractSignatureLocation; // string
  public $DinnerAdditionalInformation; // string
  public $DinnerPrivateRoom; // boolean
  public $DinnerAVRequirements; // string
  public $DinnerAlcoholPolicy; // string
  public $DinnerSpecialNeeds; // string
}

class RFPSupplierDetail {
  public $InternalNote; // string
  public $VenueBrand; // string
  public $VenueChain; // string
  public $Preferred; // boolean
  public $MainPhone; // string
  public $SalesPhone; // string
  public $BidReceivedDate; // dateTime
  public $RFPSentDate; // dateTime
}

class SupplierDetail {
  public $ProposalId; // string
  public $VenueId; // string
  public $VenueName; // string
  public $VenueCode; // string
  public $VenueType; // string
  public $VenueCity; // string
  public $VenueMMA; // string
  public $Status; // string
  public $RFPLastSentDate; // dateTime
  public $RFPViewedDate; // dateTime
  public $RFPLastViewedDate; // dateTime
  public $ResponseReason; // string
  public $ResponseReasonComment; // string
}

class SupplierRFPInfoDetail {
  public $RFPReceivedDate; // dateTime
  public $BidSentDate; // dateTime
  public $SourceId; // string
  public $Archived; // boolean
}

class UserDetail {
  public $UserId; // string
  public $UserName; // string
  public $FirstName; // string
  public $LastName; // string
}

class SupplierRFP {
  public $EventInfo; // SupplierRFPEventInfo
  public $OrganizationInfo; // RFPOrganizationInfo
  public $KeyContactInfo; // RFPKeyContactInfo
  public $EventRequirementInfo; // RFPEventRequirementInfo
  public $SleepRoomInfo; // RFPSleepRoomInfo
  public $AttachmentDetail; // RFPAttachmentDetail
  public $QuestionDetail; // RFPQuestionDetail
  public $DinnerInfo; // RFPDinnerInfo
  public $SupplierDetail; // SupplierRFPInfoDetail
  public $RecipientDetail; // SupplierRFPRecipientDetail
  public $ForwardHistoryDetail; // SupplierRFPForwardHistoryDetail
  public $AssignmentHistoryDetail; // SupplierRFPAssignmentHistoryDetail
  public $RFPType; // string
  public $RFPStatus; // string
  public $RFPCode; // string
  public $RFPName; // string
  public $QuickRFP; // boolean
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $ResponseDueDate; // dateTime
  public $DecisionDate; // dateTime
  public $Currency; // string
  public $RFPDescription; // string
  public $DecisionFactors; // string
  public $Commissionable; // boolean
  public $CommissionRate; // integer
  public $LastModifiedDate; // dateTime
}

class SupplierRFPRecipientDetail {
  public $RecipientDate; // dateTime
  public $RecipientEmailAddress; // string
  public $RecipientType; // string
}

class SupplierRFPForwardHistoryDetail {
  public $SenderFirstName; // string
  public $SenderLastName; // string
  public $SenderEmailAddress; // string
  public $ForwardedVenueName; // string
  public $ForwardedVenueCode; // string
  public $ForwardAdditionalInformation; // string
  public $ForwardDate; // dateTime
}

class SupplierRFPAssignmentHistoryDetail {
  public $AssigneeFirstName; // string
  public $AssigneeLastName; // string
  public $AssigneeEmailAddress; // string
  public $AssignorEmailAddress; // string
  public $AssignmentStatus; // string
  public $AssignmentMessage; // string
  public $CurrentAssignee; // boolean
}

class Proposal {
  public $VenueInfo; // ProposalVenueInfo
  public $EventInfo; // ProposalEventInfo
  public $KeyContactInfo; // ProposalKeyContactInfo
  public $SleepRoomInfo; // ProposalSleepRoomInfo
  public $EventRequirementsInfo; // ProposalEventRequirementsInfo
  public $AttachmentDetail; // ProposalAttachmentDetail
  public $SurveyDetail; // ProposalSurveyDetail
  public $RFPId; // string
  public $RFPType; // string
  public $RFPStatus; // string
  public $RFPCode; // string
  public $RFPName; // string
  public $ProposalStatus; // string
  public $ProposalSentDate; // dateTime
  public $Commissionable; // boolean
  public $CommissionRate; // integer
  public $InternalNote; // string
  public $CreatedDate; // dateTime
  public $CreatedBy; // string
  public $LastModifiedDate; // dateTime
  public $LastModifiedBy; // string
}

class ProposalVenueInfo {
  public $VenueName; // string
  public $VenueType; // string
  public $VenueCode; // string
  public $VenueDescription; // string
  public $VenuePhone; // string
  public $VenueAddress1; // string
  public $VenueAddress2; // string
  public $VenueCity; // string
  public $VenueState; // string
  public $VenueStateCode; // string
  public $VenuePostalCode; // string
  public $VenueCountry; // string
  public $VenueCountryCode; // string
  public $VenueMMA; // string
  public $VenueBrand; // string
  public $VenueChain; // string
}

class ProposalEventInfo {
  public $EventStartDate; // dateTime
  public $EventEndDate; // dateTime
  public $Availability; // string
  public $Currency; // string
  public $EstimatedTotalCost; // double
  public $AdditionalInformation; // string
  public $AlternateStartDate1; // dateTime
  public $AlternateEndDate1; // dateTime
  public $AlternateSleepRoomRate1; // string
  public $AlternateAdditionalInformation1; // string
  public $AlternateStartDate2; // dateTime
  public $AlternateEndDate2; // dateTime
  public $AlternateSleepRoomRate2; // string
  public $AlternateAdditionalInformation2; // string
  public $ConcessionAdditionalInformation; // string
}

class ProposalSleepRoomInfo {
  public $SleepRoomAvailabilityDetail; // ProposalSleepRoomAvailabilityDetail
  public $AdditionalFeeDetail; // ProposalAdditionalFeeDetail
  public $CheckInDate; // dateTime
  public $SleepRoomNeedsMet; // boolean
  public $SleepRoomNeedsMetAdditionalInfo; // string
  public $FeeAdditionalInformation; // string
}

class ProposalSleepRoomAvailabilityDetail {
  public $DayNumber; // integer
  public $Date; // dateTime
  public $AnyRoomQuantity; // integer
  public $AnyRoomRate; // double
  public $SingleRoomQuantity; // integer
  public $SingleRoomRate; // double
  public $DoubleRoomQuantity; // integer
  public $DoubleRoomRate; // double
  public $SuiteQuantity; // integer
  public $SuiteRate; // double
  public $SleepRoomNote; // string
}

class ProposalAdditionalFeeDetail {
  public $Category; // string
  public $Type; // string
  public $Value; // string
}

class ProposalEventRequirementsInfo {
  public $MeetingRoomAvailabilityDetail; // ProposalMeetingRoomAvailabilityDetail
  public $ProposalEstimatedCostDetail; // ProposalEstimatedCostDetail
  public $MeetingRoomNeedsMet; // boolean
  public $MeetingRoomNeedsMetAdditionalInfo; // string
  public $TotalFoodAndBeverageMinimum; // double
  public $ApplicableTax; // integer
  public $ServiceCharge; // integer
  public $MeetingRoomAdditionalInformation; // string
  public $AmenityAdditionalInformation; // string
}

class ProposalMeetingRoomAvailabilityDetail {
  public $DayNumber; // integer
  public $StartTime; // dateTime
  public $EndTime; // dateTime
  public $AgendaItem; // string
  public $AgendaItemType; // string
  public $SetupType; // string
  public $RoomName; // string
  public $RoomSize; // integer
  public $NumberOfPeople; // integer
  public $TwentyFourHourHold; // boolean
  public $Note; // string
  public $CeilingHeight; // double
}

class ProposalEstimatedCostDetail {
  public $Amount; // double
  public $Quantity; // integer
  public $Type; // string
  public $TaxOrServiceCharge; // string
  public $Note; // string
}

class SupplierProposal {
  public $VenueInfo; // SupplierProposalVenueInfo
  public $EventInfo; // ProposalEventInfo
  public $KeyContactInfo; // ProposalKeyContactInfo
  public $SleepRoomInfo; // ProposalSleepRoomInfo
  public $EventRequirementsInfo; // ProposalEventRequirementsInfo
  public $AttachmentDetail; // ProposalAttachmentDetail
  public $SurveyDetail; // ProposalSurveyDetail
  public $RFPId; // string
  public $RFPType; // string
  public $RFPStatus; // string
  public $RFPCode; // string
  public $RFPName; // string
  public $ProposalStatus; // string
  public $ProposalSentDate; // dateTime
  public $Commissionable; // boolean
  public $CommissionRate; // integer
  public $CreatedDate; // dateTime
  public $CreatedBy; // string
  public $LastModifiedDate; // dateTime
  public $LastModifiedBy; // string
}

class SupplierProposalVenueInfo {
  public $VenueName; // string
  public $VenueType; // string
  public $VenueCode; // string
  public $SourceId; // string
}

class RateHistory {
  public $ID; // string
  public $VenueID; // string
  public $VenueCode; // string
  public $VenueName; // string
  public $RateName; // string
  public $RateStartDate; // dateTime
  public $RateEndDate; // dateTime
  public $MinimumRate; // double
  public $MaximumRate; // double
  public $RoomType; // string
  public $RoomNightCount; // integer
  public $Comment; // string
  public $Currency; // string
  public $ContractedRate; // boolean
  public $ContractDate; // dateTime
  public $CreatedDate; // dateTime
  public $CreatedBy; // string
  public $LastModifiedDate; // dateTime
  public $LastModifiedBy; // string
}

class Supplier {
  public $ImageDetail; // SupplierImageDetail
  public $RateHistoryDetail; // SupplierRateHistoryDetail
  public $ExternalIdDetail; // SupplierExternalIdDetail
  public $ID; // string
  public $Name; // string
  public $VenueCode; // string
  public $VenueType; // string
  public $Brand; // string
  public $ChainAffiliation; // string
  public $MainPhoneNumber; // string
  public $MainFaxNumber; // string
  public $SalesPhoneNumber; // string
  public $SalesFaxNumber; // string
  public $SourceId; // string
  public $VenueWebsiteURL; // string
  public $CventStarRating; // string
  public $Address1; // string
  public $Address2; // string
  public $City; // string
  public $State; // string
  public $StateCode; // string
  public $PostalCode; // string
  public $Country; // string
  public $CountryCode; // string
  public $MetroArea; // string
  public $Currency; // string
  public $Description; // string
  public $CancellationPolicy; // string
  public $TotalSleepRooms; // integer
  public $TotalSingleRooms; // integer
  public $TotalDoubleRooms; // integer
  public $TotalSuites; // integer
}

class SupplierImageDetail {
  public $ImageName; // string
  public $ImageCategory; // string
  public $ImageUrl; // string
}

class SupplierRateHistoryDetail {
  public $RateHistoryId; // string
}

class SupplierExternalIdDetail {
  public $ExternalIdType; // string
  public $ExternalId; // string
}

class Event {
  public $ProductDetail; // ProductDetail
  public $CustomFieldDetail; // CustomFieldDetail
  public $WeblinkDetail; // WeblinkDetail
  public $DocumentDetail; // DocumentDetail
  public $EventTitle; // string
  public $EventCode; // string
  public $EventStartDate; // dateTime
  public $EventEndDate; // dateTime
  public $EventLaunchDate; // dateTime
  public $Timezone; // string
  public $EventDescription; // string
  public $InternalNote; // string
  public $EventStatus; // string
  public $Capacity; // int
  public $Category; // string
  public $Currency; // string
  public $PlanningStatus; // string
  public $Hidden; // boolean
  public $Location; // string
  public $StreetAddress1; // string
  public $StreetAddress2; // string
  public $StreetAddress3; // string
  public $City; // string
  public $State; // string
  public $StateCode; // string
  public $PostalCode; // string
  public $Country; // string
  public $CountryCode; // string
  public $PhoneNumber; // string
  public $PlannerFirstName; // string
  public $PlannerLastName; // string
  public $PlannerEmailAddress; // string
  public $LastModifiedDate; // dateTime
  public $RSVPbyDate; // dateTime
  public $ClosedBy; // string
}

class ProductDetail {
  public $CustomFieldDetail; // CustomFieldDetail
  public $ProductId; // string
  public $ProductName; // string
  public $ProductCode; // string
  public $ProductType; // string
  public $ProductDescription; // string
  public $StartTime; // dateTime
  public $EndTime; // dateTime
  public $Status; // string
  public $Capacity; // int
}

class DocumentDetail {
  public $FileName; // string
  public $FileType; // string
  public $FileSize; // int
  public $UploadDate; // dateTime
  public $FileURL; // string
}

class Invitee {
  public $InternalInfoDetail; // InternalInfoDetail
  public $RegretSurveyDetail; // RegretSurveyDetail
  public $WeblinkDetail; // WeblinkDetail
  public $ContactId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $CCEmailAddress; // string
  public $WorkPhone; // string
  public $Participant; // boolean
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $EventStartDate; // dateTime
  public $Status; // InviteeStatus
  public $InternalNote; // string
  public $ConfirmationNumber; // string
  public $ReferenceId; // string
  public $LastModifiedDate; // dateTime
  public $OriginalResponseDate; // dateTime
}

class InternalInfoDetail {
  public $AnswerText; // string
  public $QuestionText; // string
}

class RegretSurveyDetail {
  public $AnswerText; // string
  public $EventAnswer; // EventAnswer
  public $QuestionId; // string
  public $QuestionCode; // string
  public $SurveyType; // string
  public $QuestionText; // string
}

class EventAnswer {
  public $AnswerPart; // string
  public $AnswerColumn; // string
  public $AnswerText; // string
  public $AnswerOther; // string
  public $AnswerComment; // string
}

class InviteeStatus {
  const No_Response = 'No Response';
  const Accepted = 'Accepted';
  const Declined = 'Declined';
  const Visited = 'Visited';
  const Waitlist = 'Waitlist';
  const Cancelled = 'Cancelled';
  const Pending_Approval = 'Pending Approval';
  const Denied_Approval = 'Denied Approval';
}

class Registration {
  public $EventSurveyDetail; // EventSurveyDetail
  public $GuestDetail; // GuestDetail
  public $OrderDetail; // OrderDetail
  public $PaymentDetail; // PaymentDetail
  public $InviteeId; // string
  public $ContactId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $CCEmailAddress; // string
  public $WorkPhone; // string
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $EventStartDate; // dateTime
  public $Status; // string
  public $InternalNote; // string
  public $InvitedBy; // string
  public $RegistrationDate; // dateTime
  public $CancelledDate; // dateTime
  public $OriginalResponseDate; // dateTime
  public $LastModifiedDate; // dateTime
  public $ModifiedBy; // string
  public $ResponseMethod; // string
  public $ConfirmationNumber; // string
  public $RegistrationType; // string
  public $Participant; // boolean
  public $Credit; // double
}

class EventSurveyDetail {
  public $Answer; // EventAnswer
  public $AnswerText; // string
  public $SurveyType; // string
  public $QuestionId; // string
  public $QuestionCode; // string
  public $QuestionText; // string
}

class GuestDetail {
  public $EventSurveyDetail; // EventSurveyDetail
  public $GuestId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $Phone; // string
  public $EmailAddress; // string
  public $Address1; // string
  public $Address2; // string
  public $Address3; // string
  public $City; // string
  public $State; // string
  public $PostalCode; // string
  public $Country; // string
  public $RegistrationType; // string
  public $Participant; // boolean
  public $CountryCode; // string
  public $StateCode; // string
  public $ConfirmationNumber; // string
}

class OrderDetail {
  public $DiscountDetail; // DiscountDetail
  public $OrderDetailItemId; // string
  public $OrderDetailId; // string
  public $FirstName; // string
  public $LastName; // string
  public $ProductId; // string
  public $ProductName; // string
  public $ProductCode; // string
  public $Quantity; // int
  public $ProductType; // string
  public $ProductDescription; // string
  public $StartTime; // dateTime
  public $EndTime; // dateTime
  public $Action; // string
  public $ActionDate; // dateTime
  public $Amount; // double
  public $AmountPaid; // double
  public $AmountDue; // double
  public $OrderNumber; // string
  public $Participant; // boolean
}

class DiscountDetail {
  public $DiscountDetailId; // string
  public $DiscountCode; // string
  public $DiscountName; // string
  public $DiscountType; // string
  public $DiscountValue; // decimal
  public $DiscountAmount; // decimal
}

class PaymentDetail {
  public $TransactionId; // string
  public $TransactionDate; // dateTime
  public $PaymentType; // string
  public $ReferenceNumber; // string
  public $TransactionType; // TransactionType
  public $Amount; // double
  public $TransactionNumber; // string
}

class TransactionType {
  const Online_Charge = 'Online Charge';
  const Online_Refund = 'Online Refund';
  const Offline_Charge = 'Offline Charge';
  const Offline_Refund = 'Offline Refund';
}

class Transaction {
  public $DistributionDetail; // DistributionDetail
  public $ContactId; // string
  public $InviteeId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $WorkPhone; // string
  public $EventId; // string
  public $EventCode; // string
  public $EventTitle; // string
  public $EventStartDate; // dateTime
  public $TransactionType; // TransactionType
  public $Success; // boolean
  public $TransactionNumber; // string
  public $PaymentType; // string
  public $NameOnCard; // string
  public $ReferenceNumber; // string
  public $BatchNumber; // string
  public $Amount; // double
  public $PaidInFull; // boolean
  public $TransactionDate; // dateTime
  public $Note; // string
  public $LastModifiedDate; // dateTime
  public $ModifiedBy; // string
}

class DistributionDetail {
  public $ProductId; // string
  public $ProductName; // string
  public $ProductCode; // string
  public $ProductType; // string
  public $OrderPrice; // double
  public $AmountApplied; // double
  public $GLCode; // string
  public $OrderNumber; // string
}

class CvAnswer {
  public $QuestionCode; // string
  public $Answer; // string
}

class Respondent {
  public $WeblinkDetail; // WeblinkDetail
  public $ContactId; // string
  public $SourceId; // string
  public $FirstName; // string
  public $LastName; // string
  public $Company; // string
  public $Title; // string
  public $EmailAddress; // string
  public $WorkPhone; // string
  public $SurveyId; // string
  public $SurveyCode; // string
  public $SurveyTitle; // string
  public $SurveyLaunchDate; // dateTime
  public $Status; // RespondentStatus
  public $InternalNote; // string
  public $ResponseScore; // decimal
}

class RespondentStatus {
  const No_Response = 'No Response';
  const Visited = 'Visited';
  const Partial_Response = 'Partial Response';
  const Complete_Response = 'Complete Response';
}

class GetUpdatedResult {
  public $Id; // string
}

class CvSearch {
  public $Filter; // Filter
  public $SearchType; // CvSearchType
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class Filter {
  public $Field; // string
  public $Operator; // CvSearchOperatorType
  public $Value; // string
  public $ValueArray; // ArrayOfString
  function __construct($params=array()) { foreach ($params as $field => $val) { $this->$field = $val; } }
}

class CvSearchOperatorType {
  const Equals = 'Equals';
  const Not_Equal_to = 'Not Equal to';
  const Less_than = 'Less than';
  const Greater_than = 'Greater than';
  const Less_than_or_Equal_to = 'Less than or Equal to';
  const Greater_than_or_Equal_to = 'Greater than or Equal to';
  const Contains = 'Contains';
  const Does_not_Contain = 'Does not Contain';
  const Starts_with = 'Starts with';
  const Includes = 'Includes';
  const Excludes = 'Excludes';
}

class CvSearchType {
  const AndSearch = 'AndSearch';
  const OrSearch = 'OrSearch';
}

class SearchResult {
  public $Id; // string
}

class DescribeGlobalResult {
  public $CvObjectTypes; // string
  public $LookUps; // ArrayOfLookUp
  public $MaxAPICalls; // int
  public $CurrentAPICalls; // int
  public $MaxBatchSize; // int
  public $MaxRecordSet; // int
}

class LookUp {
  public $Id; // string
  public $Name; // string
  public $Code; // string
  public $Type; // string
}

class CvObjectTypeArray {
  public $CvObjectType; // CvObjectType
}

class DescribeCvObjectResults {
  public $DescribeCvObjectResult; // DescribeCvObjectResult
}

class DescribeCvObjectResult {
  public $Field; // Field
  public $CustomField; // CustomField
  public $Name; // string
  public $Creatable; // boolean
  public $Updateable; // boolean
  public $Deletable; // boolean
  public $Replicateable; // boolean
  public $Retrieveable; // boolean
  public $Searchable; // boolean
}

class Field {
  public $LookUpDetail; // LookUpDetail
  public $Name; // string
  public $ObjectLocation; // string
  public $DataType; // string
  public $MaxLength; // int
  public $Searchable; // boolean
  public $Required; // boolean
  public $ReadOnly; // boolean
  public $DefaultValue; // string
  public $DefaultSearchValue; // string
}

class LookUpDetail {
  public $Value; // string
}

class CustomField {
  public $AnswerDetail; // AnswerDetail
  public $Id; // string
  public $Name; // string
  public $Category; // string
  public $FieldType; // string
  public $Format; // string
  public $SortOrder; // string
}

class LoginResult {
  public $LoginSuccess; // boolean
  public $ServerURL; // string
  public $CventSessionHeader; // string
  public $ErrorMessage; // string
}

class CreateContactResultArray {
  public $CreateContactResult; // CreateContactResult
}

class CreateContactResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $SourceId; // string
  public $Success; // boolean
}

class Error {
  public $Code; // string
  public $Description; // string
}

class UpdateContactResultArray {
  public $UpdateContactResult; // UpdateContactResult
}

class UpdateContactResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $SourceId; // string
  public $Success; // boolean
}

class UpdateInviteeInternalInfoResultArray {
  public $UpdateInviteeInternalInfoResult; // UpdateInviteeInternalInfoResult
}

class UpdateInviteeInternalInfoResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class DeleteContactResultArray {
  public $DeleteContactResult; // DeleteContactResult
}

class DeleteContactResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $SourceId; // string
  public $Success; // boolean
}

class ManageGroupAction {
  const Add = 'Add';
  const Remove = 'Remove';
}

class CvObjectArray {
  public $CvObject; // CvObject
}

class ManageContactGroupMembersResultArray {
  public $ManageContactGroupResult; // ManageContactGroupResult
}

class ManageContactGroupResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class CreateContactGroupResultArray {
  public $CreateContactGroupResult; // CreateContactGroupResult
}

class CreateContactGroupResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $Success; // boolean
  public $ReferenceId; // string
}

class ActivityType {
  const Event = 'Event';
  const Survey = 'Survey';
}

class TransferInviteeResultArray {
  public $TransferInviteeResult; // TransferInviteeResult
}

class TransferInviteeResult {
  public $WeblinkDetail; // WeblinkDetail
  public $Errors; // ArrayOfError
  public $Id; // string
  public $Success; // boolean
  public $ReferenceId; // string
}

class CheckInResultArray {
  public $CheckInResult; // CheckInResult
}

class CheckInResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class RegistrationAction {
  const Register = 'Register';
  const Decline = 'Decline';
  const Waitlist = 'Waitlist';
  const Cancel = 'Cancel';
}

class SimpleEventRegistrationResultArray {
  public $SimpleEventRegistrationResult; // SimpleEventRegistrationResult
}

class SimpleEventRegistrationResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class SendEmailRequest {
  public $RecipientId; // ArrayOfCvObject
  public $ActivityType; // ActivityType
  public $ActivityId; // string
  public $EmailTemplateName; // EmailTemplate
  public $ResendToPreviousRecipients; // boolean
  public $EmailName; // string
}

class EmailTemplate {
  const Invitation = 'Invitation';
  const CustomInviteeMessage = 'CustomInviteeMessage';
  const InvitationReminder = 'InvitationReminder';
  const CustomUndecidedMessage = 'CustomUndecidedMessage';
  const RegistrationConfirmation = 'RegistrationConfirmation';
  const EventReminder = 'EventReminder';
  const CustomAttendeeMessage = 'CustomAttendeeMessage';
  const ModificationConfirmation = 'ModificationConfirmation';
  const CancellationConfirmation = 'CancellationConfirmation';
  const Regret = 'Regret';
  const CustomDeclineeMessage = 'CustomDeclineeMessage';
  const PostEventFollowUp = 'PostEventFollowUp';
  const CustomAttendedMessage = 'CustomAttendedMessage';
  const ApprovalDenied = 'ApprovalDenied';
  const ApprovalPending = 'ApprovalPending';
  const CustomEmail = 'CustomEmail';
  const SurveyInvitation = 'SurveyInvitation';
  const SurveyCustomInviteeMessage = 'SurveyCustomInviteeMessage';
  const SurveyReminder = 'SurveyReminder';
  const SurveyCustomNoResponseMessage = 'SurveyCustomNoResponseMessage';
  const SurveyPartiallyCompleteMessage = 'SurveyPartiallyCompleteMessage';
  const SurveyCustomMessageToPartials = 'SurveyCustomMessageToPartials';
  const SurveyCompletionMessage = 'SurveyCompletionMessage';
  const SurveyCustomMessageToRespondents = 'SurveyCustomMessageToRespondents';
  const SurveyCustomEmail = 'SurveyCustomEmail';
}

class SendEmailResultArray {
  public $SendEmailResult; // SendEmailResult
}

class SendEmailResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class CreateUserResultArray {
  public $CreateUserResult; // CreateUserResult
}

class CreateUserResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class UpdateUserResultArray {
  public $UpdateUserResult; // UpdateUserResult
}

class UpdateUserResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class DeleteUserResultArray {
  public $DeleteUserResult; // DeleteUserResult
}

class DeleteUserResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class ManageUserGroupResultArray {
  public $ManageUserGroupResult; // ManageUserGroupResult
}

class ManageUserGroupResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class CreateNoRegEventResultArray {
  public $CreateNoRegEventResult; // CreateNoRegEventResult
}

class CreateNoRegEventResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class CreateRateHistoryResultArray {
  public $CreateRateHistoryResult; // CreateRateHistoryResult
}

class CreateRateHistoryResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class DeleteRateHistoryResultArray {
  public $DeleteRateHistoryResult; // DeleteRateHistoryResult
}

class DeleteRateHistoryResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}

class CreateTransactionResultArray {
  public $CreateTransactionResult; // CreateTransactionResult
}

class CreateTransactionResult {
  public $Errors; // ArrayOfError
  public $Id; // string
  public $ReferenceId; // string
  public $Success; // boolean
}


/**
 * CVentV200611 class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class CVentV200611 extends SoapClient {

  # This will be a copy of the cvent DescribeGlobal object.
  public $describeglobal = false;

  # We need to page our Retrieve() calls if the number of Ids we are 
  # retrieving exceeds DescribeGlobal.MaxBatchSize, so we'll stick that number 
  # here for easy reference.
  private $maxbatchsize = 0;
  private $maxrecordset = 0;

  private static $classmap = array(
                                    'Retrieve' => 'Retrieve',
                                    'RetrieveResponse' => 'RetrieveResponse',
                                    'CventSessionHeader' => 'CventSessionHeader',
                                    'GetUpdated' => 'GetUpdated',
                                    'GetUpdatedResponse' => 'GetUpdatedResponse',
                                    'Search' => 'Search',
                                    'SearchResponse' => 'SearchResponse',
                                    'DescribeGlobal' => 'DescribeGlobal',
                                    'DescribeGlobalResponse' => 'DescribeGlobalResponse',
                                    'DescribeCvObject' => 'DescribeCvObject',
                                    'DescribeCvObjectResponse' => 'DescribeCvObjectResponse',
                                    'Login' => 'Login',
                                    'LoginResponse' => 'LoginResponse',
                                    'CreateContact' => 'CreateContact',
                                    'CreateContactResponse' => 'CreateContactResponse',
                                    'UpdateContact' => 'UpdateContact',
                                    'UpdateContactResponse' => 'UpdateContactResponse',
                                    'UpdateInviteeInternalInfo' => 'UpdateInviteeInternalInfo',
                                    'UpdateInviteeInternalInfoResponse' => 'UpdateInviteeInternalInfoResponse',
                                    'DeleteContact' => 'DeleteContact',
                                    'DeleteContactResponse' => 'DeleteContactResponse',
                                    'ManageContactGroupMembers' => 'ManageContactGroupMembers',
                                    'ManageContactGroupMembersResponse' => 'ManageContactGroupMembersResponse',
                                    'CreateContactGroup' => 'CreateContactGroup',
                                    'CreateContactGroupResponse' => 'CreateContactGroupResponse',
                                    'TransferInvitee' => 'TransferInvitee',
                                    'TransferInviteeResponse' => 'TransferInviteeResponse',
                                    'CheckIn' => 'CheckIn',
                                    'CheckInResponse' => 'CheckInResponse',
                                    'SimpleEventRegistration' => 'SimpleEventRegistration',
                                    'SimpleEventRegistrationResponse' => 'SimpleEventRegistrationResponse',
                                    'SendEmail' => 'SendEmail',
                                    'SendEmailResponse' => 'SendEmailResponse',
                                    'CreateUser' => 'CreateUser',
                                    'CreateUserResponse' => 'CreateUserResponse',
                                    'UpdateUser' => 'UpdateUser',
                                    'UpdateUserResponse' => 'UpdateUserResponse',
                                    'DeleteUser' => 'DeleteUser',
                                    'DeleteUserResponse' => 'DeleteUserResponse',
                                    'ManageUserGroup' => 'ManageUserGroup',
                                    'ManageUserGroupResponse' => 'ManageUserGroupResponse',
                                    'CreateNoRegEvent' => 'CreateNoRegEvent',
                                    'CreateNoRegEventResponse' => 'CreateNoRegEventResponse',
                                    'CreateRateHistory' => 'CreateRateHistory',
                                    'CreateRateHistoryResponse' => 'CreateRateHistoryResponse',
                                    'DeleteRateHistory' => 'DeleteRateHistory',
                                    'DeleteRateHistoryResponse' => 'DeleteRateHistoryResponse',
                                    'CreateTransaction' => 'CreateTransaction',
                                    'CreateTransactionResponse' => 'CreateTransactionResponse',
                                    'CvObjectType' => 'CvObjectType',
                                    'IdArray' => 'IdArray',
                                    'RetrieveResult' => 'RetrieveResult',
                                    'CvObject' => 'CvObject',
                                    'BudgetItem' => 'BudgetItem',
                                    'CostDetail' => 'CostDetail',
                                    'SavingsDetail' => 'SavingsDetail',
                                    'BudgetPaymentDetail' => 'BudgetPaymentDetail',
                                    'Budget' => 'Budget',
                                    'CategoryDetail' => 'CategoryDetail',
                                    'AmountDetail' => 'AmountDetail',
                                    'EventParameters' => 'EventParameters',
                                    'CustomFieldDetail' => 'CustomFieldDetail',
                                    'EventQuestion' => 'EventQuestion',
                                    'AnswerDetail' => 'AnswerDetail',
                                    'RowDetail' => 'RowDetail',
                                    'EventEmailHistory' => 'EventEmailHistory',
                                    'UserRole' => 'UserRole',
                                    'UserRights' => 'UserRights',
                                    'Contact' => 'Contact',
                                    'ContactGroupDetail' => 'ContactGroupDetail',
                                    'PrimaryAddressType' => 'PrimaryAddressType',
                                    'ContactGroup' => 'ContactGroup',
                                    'User' => 'User',
                                    'UserGroupDetail' => 'UserGroupDetail',
                                    'VisibilityDefaults' => 'VisibilityDefaults',
                                    'CvVisibilityType' => 'CvVisibilityType',
                                    'CvUserType' => 'CvUserType',
                                    'MeetingRequestUser' => 'MeetingRequestUser',
                                    'UserGroup' => 'UserGroup',
                                    'Travel' => 'Travel',
                                    'HotelRequest' => 'HotelRequest',
                                    'TravelSurveyDetail' => 'TravelSurveyDetail',
                                    'TravelAnswer' => 'TravelAnswer',
                                    'CarRequest' => 'CarRequest',
                                    'AirRequest' => 'AirRequest',
                                    'AirActual' => 'AirActual',
                                    'FlightDetail' => 'FlightDetail',
                                    'Survey' => 'Survey',
                                    'WeblinkDetail' => 'WeblinkDetail',
                                    'Response' => 'Response',
                                    'ResponseSurveyDetail' => 'ResponseSurveyDetail',
                                    'SurveyDetail' => 'SurveyDetail',
                                    'Answer' => 'Answer',
                                    'SurveyEmailHistory' => 'SurveyEmailHistory',
                                    'RFP' => 'RFP',
                                    'RFPEventInfo' => 'RFPEventInfo',
                                    'BaseRFPEventInfo' => 'BaseRFPEventInfo',
                                    'SupplierRFPEventInfo' => 'SupplierRFPEventInfo',
                                    'SupplierRFPEventHistoryDetail' => 'SupplierRFPEventHistoryDetail',
                                    'BaseRFPEventHistoryDetail' => 'BaseRFPEventHistoryDetail',
                                    'RFPEventHistoryDetail' => 'RFPEventHistoryDetail',
                                    'RFPOrganizationInfo' => 'RFPOrganizationInfo',
                                    'RFPKeyContactInfo' => 'RFPKeyContactInfo',
                                    'KeyContactInfo' => 'KeyContactInfo',
                                    'ProposalKeyContactInfo' => 'ProposalKeyContactInfo',
                                    'RFPEventRequirementInfo' => 'RFPEventRequirementInfo',
                                    'RFPMeetingRoomDetail' => 'RFPMeetingRoomDetail',
                                    'RFPSleepRoomInfo' => 'RFPSleepRoomInfo',
                                    'RFPSleepRoomDetail' => 'RFPSleepRoomDetail',
                                    'RFPOccupancyPerRoomDetail' => 'RFPOccupancyPerRoomDetail',
                                    'RFPAttachmentDetail' => 'RFPAttachmentDetail',
                                    'AttachmentDetail' => 'AttachmentDetail',
                                    'ProposalAttachmentDetail' => 'ProposalAttachmentDetail',
                                    'RFPQuestionDetail' => 'RFPQuestionDetail',
                                    'ProposalSurveyDetail' => 'ProposalSurveyDetail',
                                    'ProposalAnswer' => 'ProposalAnswer',
                                    'RFPDinnerInfo' => 'RFPDinnerInfo',
                                    'RFPSupplierDetail' => 'RFPSupplierDetail',
                                    'SupplierDetail' => 'SupplierDetail',
                                    'SupplierRFPInfoDetail' => 'SupplierRFPInfoDetail',
                                    'UserDetail' => 'UserDetail',
                                    'SupplierRFP' => 'SupplierRFP',
                                    'SupplierRFPRecipientDetail' => 'SupplierRFPRecipientDetail',
                                    'SupplierRFPForwardHistoryDetail' => 'SupplierRFPForwardHistoryDetail',
                                    'SupplierRFPAssignmentHistoryDetail' => 'SupplierRFPAssignmentHistoryDetail',
                                    'Proposal' => 'Proposal',
                                    'ProposalVenueInfo' => 'ProposalVenueInfo',
                                    'ProposalEventInfo' => 'ProposalEventInfo',
                                    'ProposalSleepRoomInfo' => 'ProposalSleepRoomInfo',
                                    'ProposalSleepRoomAvailabilityDetail' => 'ProposalSleepRoomAvailabilityDetail',
                                    'ProposalAdditionalFeeDetail' => 'ProposalAdditionalFeeDetail',
                                    'ProposalEventRequirementsInfo' => 'ProposalEventRequirementsInfo',
                                    'ProposalMeetingRoomAvailabilityDetail' => 'ProposalMeetingRoomAvailabilityDetail',
                                    'ProposalEstimatedCostDetail' => 'ProposalEstimatedCostDetail',
                                    'SupplierProposal' => 'SupplierProposal',
                                    'SupplierProposalVenueInfo' => 'SupplierProposalVenueInfo',
                                    'RateHistory' => 'RateHistory',
                                    'Supplier' => 'Supplier',
                                    'SupplierImageDetail' => 'SupplierImageDetail',
                                    'SupplierRateHistoryDetail' => 'SupplierRateHistoryDetail',
                                    'SupplierExternalIdDetail' => 'SupplierExternalIdDetail',
                                    'Event' => 'Event',
                                    'ProductDetail' => 'ProductDetail',
                                    'DocumentDetail' => 'DocumentDetail',
                                    'Invitee' => 'Invitee',
                                    'InternalInfoDetail' => 'InternalInfoDetail',
                                    'RegretSurveyDetail' => 'RegretSurveyDetail',
                                    'EventAnswer' => 'EventAnswer',
                                    'InviteeStatus' => 'InviteeStatus',
                                    'Registration' => 'Registration',
                                    'EventSurveyDetail' => 'EventSurveyDetail',
                                    'GuestDetail' => 'GuestDetail',
                                    'OrderDetail' => 'OrderDetail',
                                    'DiscountDetail' => 'DiscountDetail',
                                    'PaymentDetail' => 'PaymentDetail',
                                    'TransactionType' => 'TransactionType',
                                    'Transaction' => 'Transaction',
                                    'DistributionDetail' => 'DistributionDetail',
                                    'CvAnswer' => 'CvAnswer',
                                    'Respondent' => 'Respondent',
                                    'RespondentStatus' => 'RespondentStatus',
                                    'GetUpdatedResult' => 'GetUpdatedResult',
                                    'CvSearch' => 'CvSearch',
                                    'Filter' => 'Filter',
                                    'CvSearchOperatorType' => 'CvSearchOperatorType',
                                    'CvSearchType' => 'CvSearchType',
                                    'SearchResult' => 'SearchResult',
                                    'DescribeGlobalResult' => 'DescribeGlobalResult',
                                    'LookUp' => 'LookUp',
                                    'CvObjectTypeArray' => 'CvObjectTypeArray',
                                    'DescribeCvObjectResults' => 'DescribeCvObjectResults',
                                    'DescribeCvObjectResult' => 'DescribeCvObjectResult',
                                    'Field' => 'Field',
                                    'LookUpDetail' => 'LookUpDetail',
                                    'CustomField' => 'CustomField',
                                    'LoginResult' => 'LoginResult',
                                    'CreateContactResultArray' => 'CreateContactResultArray',
                                    'CreateContactResult' => 'CreateContactResult',
                                    'Error' => 'Error',
                                    'UpdateContactResultArray' => 'UpdateContactResultArray',
                                    'UpdateContactResult' => 'UpdateContactResult',
                                    'UpdateInviteeInternalInfoResultArray' => 'UpdateInviteeInternalInfoResultArray',
                                    'UpdateInviteeInternalInfoResult' => 'UpdateInviteeInternalInfoResult',
                                    'DeleteContactResultArray' => 'DeleteContactResultArray',
                                    'DeleteContactResult' => 'DeleteContactResult',
                                    'ManageGroupAction' => 'ManageGroupAction',
                                    'CvObjectArray' => 'CvObjectArray',
                                    'ManageContactGroupMembersResultArray' => 'ManageContactGroupMembersResultArray',
                                    'ManageContactGroupResult' => 'ManageContactGroupResult',
                                    'CreateContactGroupResultArray' => 'CreateContactGroupResultArray',
                                    'CreateContactGroupResult' => 'CreateContactGroupResult',
                                    'ActivityType' => 'ActivityType',
                                    'TransferInviteeResultArray' => 'TransferInviteeResultArray',
                                    'TransferInviteeResult' => 'TransferInviteeResult',
                                    'CheckInResultArray' => 'CheckInResultArray',
                                    'CheckInResult' => 'CheckInResult',
                                    'RegistrationAction' => 'RegistrationAction',
                                    'SimpleEventRegistrationResultArray' => 'SimpleEventRegistrationResultArray',
                                    'SimpleEventRegistrationResult' => 'SimpleEventRegistrationResult',
                                    'SendEmailRequest' => 'SendEmailRequest',
                                    'EmailTemplate' => 'EmailTemplate',
                                    'SendEmailResultArray' => 'SendEmailResultArray',
                                    'SendEmailResult' => 'SendEmailResult',
                                    'CreateUserResultArray' => 'CreateUserResultArray',
                                    'CreateUserResult' => 'CreateUserResult',
                                    'UpdateUserResultArray' => 'UpdateUserResultArray',
                                    'UpdateUserResult' => 'UpdateUserResult',
                                    'DeleteUserResultArray' => 'DeleteUserResultArray',
                                    'DeleteUserResult' => 'DeleteUserResult',
                                    'ManageUserGroupResultArray' => 'ManageUserGroupResultArray',
                                    'ManageUserGroupResult' => 'ManageUserGroupResult',
                                    'CreateNoRegEventResultArray' => 'CreateNoRegEventResultArray',
                                    'CreateNoRegEventResult' => 'CreateNoRegEventResult',
                                    'CreateRateHistoryResultArray' => 'CreateRateHistoryResultArray',
                                    'CreateRateHistoryResult' => 'CreateRateHistoryResult',
                                    'DeleteRateHistoryResultArray' => 'DeleteRateHistoryResultArray',
                                    'DeleteRateHistoryResult' => 'DeleteRateHistoryResult',
                                    'CreateTransactionResultArray' => 'CreateTransactionResultArray',
                                    'CreateTransactionResult' => 'CreateTransactionResult',
                                   );

  public function CVentV200611($wsdl = "https://api.cvent.com/soap/V200611.ASMX?WSDL", $options = array('trace' => 1)) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options);
  }

  /**
   *  Keep track of how many API calls we use and have remaining as we go.
   *  Note: The number of remaining calls is only as far as WE know. Other clients 
   *  elsewhere may be eating them up, too. At least we can *try* to be reasonable 
   *  and quit when we know we should.
   *
   *  @param $latestupdates array containing field/value pairs for events_latestupdate, registrations_latestupdate, and contacts_latestupdate
   *
   */
  public static function apicalls_log($addcall=false, $calls_remaining=null, $latestupdates=array()) {
      global $DB;
      static $log = null;
      if (!isset($log)) {
          if (!strlen(ini_get('date.timezone'))) {
              print_string('youmustsetdatetimezone', 'enrol_cvent');
              die;
          }
          $dt = new DateTime;
          date_timezone_set($dt, timezone_open('America/New_York'));
          $today_eastern = $dt->format('Ymd');
          if (!$log = $DB->get_record('cvent_apicalls_log', array('yyyymmdd' => $today_eastern))) {
              $DB->insert_record('cvent_apicalls_log', (object)array('yyyymmdd' => $today_eastern));
              $log = $DB->get_record('cvent_apicalls_log', array('yyyymmdd' => $today_eastern));
          }
      }

      $update = false;
      if (isset($calls_remaining)) {
          # Used to update to whatever we get back from DescribeGlobal()
          $log->calls_remaining = $calls_remaining;
          $update = true;
      }
      if ($addcall) {
          $log->calls_made++;
          $log->calls_remaining--;
          if ($log->calls_remaining <= 0) {
              $log->limit_exceeded = 1;
          }
          $update = true;
      }
      if (count($latestupdates)) {
          foreach ($latestupdates as $field => $timestamp) {
              $log->$field = $timestamp;
          }
          $update = true;
      }
      if ($update) {
          $DB->update_record('cvent_apicalls_log', $log);
      }
      return $log;
  }

  public function soapCall($method, $params, $options) {
      if ($method != 'Login' and $method != 'DescribeGlobal') {
          $apicalls_log = $this->apicalls_log();
          if ($apicalls_log->limit_exceeded) {
              throw new Exception("Still no API Calls remaining for today");
          }
      }
      $results = $this->__soapCall($method, $params, $options);
      if ($method != 'Login' and $method != 'DescribeGlobal') {
          $this->apicalls_log(true);
      }
      return $results;
  }

  /**
   *  
   *
   * @param Retrieve $parameters
   * @return RetrieveResponse
   */
  public function Retrieve(Retrieve $parameters) {
    return $this->soapCall('Retrieve', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  public function retrieve_pages($objecttype, $ids) {
      $allresults = array();
      for ($pagestart=0; $pagestart < count($ids); $pagestart += $this->maxbatchsize) {
          $results = $this->Retrieve(new Retrieve(array('ObjectType' => $objecttype, 'Ids' => array_slice($ids, $pagestart, $pagestart + $this->maxbatchsize))));
          $cvobjects = is_array($results->RetrieveResult->CvObject) ? $results->RetrieveResult->CvObject : array($results->RetrieveResult->CvObject);
          $allresults = array_merge($allresults, $cvobjects);
      }
      return $allresults;
  }

  /**
   *  
   *
   * @param GetUpdated $parameters
   * @return GetUpdatedResponse
   */
  public function GetUpdated(GetUpdated $parameters) {
      $getupdatedresults = $this->soapCall('GetUpdated', array($parameters),       array(
          'uri' => 'http://api.cvent.com/2006-11',
          'soapaction' => ''
      ));

      $getupdated_ids = array();
      if (is_object($getupdatedresults) and isset($getupdatedresults->GetUpdatedResult)) {
          if (is_array($getupdatedresults->GetUpdatedResult->Id)) {
              $getupdated_ids = $getupdatedresults->GetUpdatedResult->Id;
          } else {
              $getupdated_ids = array($getupdatedresults->GetUpdatedResult->Id);
          }
      }
      return $getupdated_ids;
  }

  /**
   *  
   *
   * @param Search $parameters
   * @return SearchResponse
   */
  public function Search(Search $parameters) {
    return $this->soapCall('Search', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param DescribeGlobal $parameters
   * @return DescribeGlobalResponse
   */
  public function DescribeGlobal(DescribeGlobal $parameters) {
      $apicalls_log = $this->apicalls_log();
      if ($this->describeglobal instanceof DescribeGlobalResponse) {
          # Only DescribeGlobal once
          return $apicalls_log;
      }
      $this->describeglobal = $this->soapCall('DescribeGlobal', array($parameters), array(
          'uri' => 'http://api.cvent.com/2006-11',
          'soapaction' => ''
      ));
      $this->maxbatchsize = $this->describeglobal->DescribeGlobalResult->MaxBatchSize;
      $this->maxrecordset = $this->describeglobal->DescribeGlobalResult->MaxRecordSet;
      $apicalls_log = $this->apicalls_log(true, $this->describeglobal->DescribeGlobalResult->MaxAPICalls - $this->describeglobal->DescribeGlobalResult->CurrentAPICalls);
      return $apicalls_log;
  }

  /**
   *  
   *
   * @param DescribeCvObject $parameters
   * @return DescribeCvObjectResponse
   */
  public function DescribeCvObject(DescribeCvObject $parameters) {
    return $this->soapCall('DescribeCvObject', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param Login $parameters
   * @return LoginResponse
   */
  public function Login(Login $parameters) {
    $login = $this->soapCall('Login', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
    if (!($login instanceof LoginResponse)) {
        throw new Exception('Unable to log in to Cvent');
    }
    $this->__setLocation($login->LoginResult->ServerURL);
    $this->__setSoapHeaders (
        new SoapHeader(
            'http://api.cvent.com/2006-11',
            'CventSessionHeader',
            new SoapVar(array('ns1:CventSessionValue' => $login->LoginResult->CventSessionHeader), SOAP_ENC_OBJECT)
        )
    );

    return $login;
  }

  /**
   *  
   *
   * @param CreateContact $parameters
   * @return CreateContactResponse
   */
  public function CreateContact(CreateContact $parameters) {
    return $this->soapCall('CreateContact', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param UpdateContact $parameters
   * @return UpdateContactResponse
   */
  public function UpdateContact(UpdateContact $parameters) {
    return $this->soapCall('UpdateContact', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param UpdateInviteeInternalInfo $parameters
   * @return UpdateInviteeInternalInfoResponse
   */
  public function UpdateInviteeInternalInfo(UpdateInviteeInternalInfo $parameters) {
    return $this->soapCall('UpdateInviteeInternalInfo', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param DeleteContact $parameters
   * @return DeleteContactResponse
   */
  public function DeleteContact(DeleteContact $parameters) {
    return $this->soapCall('DeleteContact', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param ManageContactGroupMembers $parameters
   * @return ManageContactGroupMembersResponse
   */
  public function ManageContactGroupMembers(ManageContactGroupMembers $parameters) {
    return $this->soapCall('ManageContactGroupMembers', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CreateContactGroup $parameters
   * @return CreateContactGroupResponse
   */
  public function CreateContactGroup(CreateContactGroup $parameters) {
    return $this->soapCall('CreateContactGroup', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param TransferInvitee $parameters
   * @return TransferInviteeResponse
   */
  public function TransferInvitee(TransferInvitee $parameters) {
    return $this->soapCall('TransferInvitee', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CheckIn $parameters
   * @return CheckInResponse
   */
  public function CheckIn(CheckIn $parameters) {
    return $this->soapCall('CheckIn', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param SimpleEventRegistration $parameters
   * @return SimpleEventRegistrationResponse
   */
  public function SimpleEventRegistration(SimpleEventRegistration $parameters) {
    return $this->soapCall('SimpleEventRegistration', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param SendEmail $parameters
   * @return SendEmailResponse
   */
  public function SendEmail(SendEmail $parameters) {
    return $this->soapCall('SendEmail', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CreateUser $parameters
   * @return CreateUserResponse
   */
  public function CreateUser(CreateUser $parameters) {
    return $this->soapCall('CreateUser', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param UpdateUser $parameters
   * @return UpdateUserResponse
   */
  public function UpdateUser(UpdateUser $parameters) {
    return $this->soapCall('UpdateUser', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param DeleteUser $parameters
   * @return DeleteUserResponse
   */
  public function DeleteUser(DeleteUser $parameters) {
    return $this->soapCall('DeleteUser', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param ManageUserGroup $parameters
   * @return ManageUserGroupResponse
   */
  public function ManageUserGroup(ManageUserGroup $parameters) {
    return $this->soapCall('ManageUserGroup', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CreateNoRegEvent $parameters
   * @return CreateNoRegEventResponse
   */
  public function CreateNoRegEvent(CreateNoRegEvent $parameters) {
    return $this->soapCall('CreateNoRegEvent', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CreateRateHistory $parameters
   * @return CreateRateHistoryResponse
   */
  public function CreateRateHistory(CreateRateHistory $parameters) {
    return $this->soapCall('CreateRateHistory', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param DeleteRateHistory $parameters
   * @return DeleteRateHistoryResponse
   */
  public function DeleteRateHistory(DeleteRateHistory $parameters) {
    return $this->soapCall('DeleteRateHistory', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param CreateTransaction $parameters
   * @return CreateTransactionResponse
   */
  public function CreateTransaction(CreateTransaction $parameters) {
    return $this->soapCall('CreateTransaction', array($parameters),       array(
            'uri' => 'http://api.cvent.com/2006-11',
            'soapaction' => ''
           )
      );
  }

}

?>
