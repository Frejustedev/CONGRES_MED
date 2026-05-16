import Public from './Public'
import Reviewer from './Reviewer'
import Staff from './Staff'
import Webhooks from './Webhooks'
import Admin from './Admin'
import Settings from './Settings'
const Controllers = {
    Public: Object.assign(Public, Public),
Reviewer: Object.assign(Reviewer, Reviewer),
Staff: Object.assign(Staff, Staff),
Webhooks: Object.assign(Webhooks, Webhooks),
Admin: Object.assign(Admin, Admin),
Settings: Object.assign(Settings, Settings),
}

export default Controllers