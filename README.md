1. **Users Table**:
    - Includes brand_user_id for seamless integration with your Brand’s core system.
    - Optional fields like first_name and last_name for personalization.
    - loyalty_tier_id to support a tiered loyalty system (e.g., Bronze, Silver, Gold).
2. **Loyalty_Tiers Table**:
    - Defines loyalty tiers with points_required to reach each tier and benefits_description for tier-specific perks.
3. **Transactions Table**:
    - Records qualifying transactions with transaction_type (e.g., airtime purchase, bill payment) and status (e.g., completed, pending, reversed) to handle reversals and ensure points are only awarded for completed transactions.
4. **Points Table**:
    - Tracks points earned and redeemed with point_type (earned or redeemed) and point_value.
    - Includes expiry_date for points (if applicable) and campaign_id to link points to specific campaigns.
    - transaction_id is nullable to support points earned from non-transaction activities (e.g., referrals, bonuses).
5. **Rewards Table**:
    - Defines available rewards with points_required, reward_type (e.g., discount, cashback), and reward_value.
    - Includes start_date and end_date to manage reward availability periods.
6. **Campaigns Table**:
    - Manages promotions with point_multiplier for bonus points.
    - target_transaction_types and target_user_segments allow campaigns to target specific transaction types or user groups (e.g., new users, high-value customers).

---

**Detailed Schema Breakdown**

**1. Users Table**

- Stores user information and links to your brand's existing user system.
- Supports a tiered loyalty system via loyalty_tier_id.

**2. Loyalty_Tiers Table**

- Defines the structure for a tiered loyalty program, including points required and benefits for each tier.

**3. Transactions Table**

- Records transaction details, including type, amount, and status, ensuring points are only awarded for completed transactions.

**4. Points Table**

- Tracks all point activities (earning and redeeming), with support for expiry and campaign linkages.
- Allows points to be earned from both transaction-based and non-transaction-based activities.

**5. Rewards Table**

- Manages redeemable rewards, supporting various reward types and time-limited availability.

**6. Campaigns Table**

- Supports promotional campaigns with point multipliers and targeted rules for specific transaction types or user segments.

---

**Database Schema in Table Form**

| **Table Name** | **Column Name** | **Data Type** | **Constraints** | **Description** |
| --- | --- | --- | --- | --- |
| **Users** | user_id | INT | PK, AUTO_INCREMENT | Unique identifier for each user |
|  | brand_user_id | VARCHAR(255) | UNIQUE, INDEX | your brand's existing user ID for integration |
|  | phone_number | VARCHAR(20) | INDEX | User's phone number |
|  | email | VARCHAR(255) | INDEX | User's email address |
|  | first_name | VARCHAR(255) |  | User's first name (optional) |
|  | last_name | VARCHAR(255) |  | User's last name (optional) |
|  | registration_date | TIMESTAMP |  | Date and time of user registration |
|  | loyalty_tier_id | INT | FK to Loyalty_Tiers | User's current loyalty tier |
| **Loyalty_Tiers** | loyalty_tier_id | INT | PK, AUTO_INCREMENT | Unique identifier for each tier |
|  | tier_name | VARCHAR(50) |  | Name of the tier (e.g., Bronze, Silver, Gold) |
|  | points_required | INT |  | Points required to reach this tier |
|  | benefits_description | TEXT |  | Description of benefits for this tier |
| **Transactions** | transaction_id | INT | PK, AUTO_INCREMENT | Unique identifier for each transaction |
|  | user_id | INT | FK to Users | User who performed the transaction |
|  | brand_transaction_id | VARCHAR(255) | UNIQUE, INDEX | your brand's transaction ID for integration |
|  | transaction_type | ENUM('airtime', 'bill_payment', 'transfer', 'etc') |  | Type of transaction |
|  | transaction_amount | DECIMAL(10,2) |  | Monetary value of the transaction |
|  | transaction_date | TIMESTAMP |  | Date and time of the transaction |
|  | status | ENUM('completed', 'pending', 'reversed') |  | Status of the transaction |
| **Points** | point_id | INT | PK, AUTO_INCREMENT | Unique identifier for each point record |
|  | user_id | INT | FK to Users | User associated with the points |
|  | transaction_id | INT | FK to Transactions, NULLABLE | Linked transaction (if points are from a transaction) |
|  | point_type | ENUM('earned', 'redeemed') |  | Type of point activity |
|  | point_value | INT |  | Number of points (positive for earned, negative for redeemed) |
|  | point_reason | VARCHAR(255) |  | Reason for points (e.g., "Airtime Purchase", "Reward Redemption") |
|  | point_date | TIMESTAMP |  | Date and time of point activity |
|  | expiry_date | DATE | NULLABLE | Expiry date for points (if applicable) |
|  | campaign_id | INT | FK to Campaigns, NULLABLE | Linked campaign (if points are from a campaign) |
| **Rewards** | reward_id | INT | PK, AUTO_INCREMENT | Unique identifier for each reward |
|  | reward_name | VARCHAR(255) |  | Name of the reward |
|  | reward_description | TEXT |  | Description of the reward |
|  | points_required | INT |  | Points required to redeem the reward |
|  | reward_type | ENUM('discount', 'cashback', 'free_service', 'etc') |  | Type of reward |
|  | reward_value | DECIMAL(10,2) |  | Value of the reward (e.g., discount amount) |
|  | is_active | BOOLEAN | DEFAULT TRUE | Indicates if the reward is currently active |
|  | start_date | DATE |  | Start date for reward availability |
|  | end_date | DATE | NULLABLE | End date for reward availability |
| **Campaigns** | campaign_id | INT | PK, AUTO_INCREMENT | Unique identifier for each campaign |
|  | campaign_name | VARCHAR(255) |  | Name of the campaign |
|  | campaign_description | TEXT |  | Description of the campaign |
|  | start_date | DATE |  | Start date of the campaign |
|  | end_date | DATE |  | End date of the campaign |
|  | point_multiplier | DECIMAL(3,2) | DEFAULT 1.0 | Multiplier for points earned during the campaign |
|  | target_transaction_types | VARCHAR(255) |  | Comma-separated list of targeted transaction types |
|  | target_user_segments | VARCHAR(255) |  | Comma-separated list of targeted user segments |

---

**Justification for Improvements**

- **Scalability**: The schema uses indexed columns (e.g., brand_user_id, transaction_date) and supports partitioning for large tables like Transactions and Points, ensuring efficient handling of high transaction volumes.
- **Flexibility**: Supports multiple point-earning mechanisms (transaction-based and non-transaction-based), diverse reward types, and targeted campaigns.
- **Integration**: Includes brand_user_id and brand_transaction_id for seamless integration with your brand's core systems.
- **Tiered Loyalty**: The Loyalty_Tiers table allows for a tiered system to incentivize higher engagement.
- **Auditability**: The Points table provides a clear history of all point activities, while the Transactions table ensures accurate tracking of transaction statuses.
- **Campaign Management**: Structured fields like target_transaction_types and target_user_segments enable precise campaign targeting.

This schema is designed to meet your brand's current needs while remaining adaptable to future enhancements, such as point expiry rules or additional reward types. It balances complexity with performance, ensuring the loyalty app can scale alongside your brand's growth.
