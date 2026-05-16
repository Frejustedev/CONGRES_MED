import DashboardController from './DashboardController'
import RegistrationManagementController from './RegistrationManagementController'
import AbstractManagementController from './AbstractManagementController'
import ContentController from './ContentController'
import GroupRegistrationController from './GroupRegistrationController'
import VisaLetterController from './VisaLetterController'
import SettingsController from './SettingsController'
import NewsManagementController from './NewsManagementController'
import BookletController from './BookletController'
import EmailTemplateController from './EmailTemplateController'
import SurveyDashboardController from './SurveyDashboardController'
const Admin = {
    DashboardController: Object.assign(DashboardController, DashboardController),
RegistrationManagementController: Object.assign(RegistrationManagementController, RegistrationManagementController),
AbstractManagementController: Object.assign(AbstractManagementController, AbstractManagementController),
ContentController: Object.assign(ContentController, ContentController),
GroupRegistrationController: Object.assign(GroupRegistrationController, GroupRegistrationController),
VisaLetterController: Object.assign(VisaLetterController, VisaLetterController),
SettingsController: Object.assign(SettingsController, SettingsController),
NewsManagementController: Object.assign(NewsManagementController, NewsManagementController),
BookletController: Object.assign(BookletController, BookletController),
EmailTemplateController: Object.assign(EmailTemplateController, EmailTemplateController),
SurveyDashboardController: Object.assign(SurveyDashboardController, SurveyDashboardController),
}

export default Admin