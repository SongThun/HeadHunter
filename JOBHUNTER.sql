-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 14, 2025 at 10:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jobhunter`
--
CREATE DATABASE IF NOT EXISTS `jobhunter` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jobhunter`;

-- --------------------------------------------------------

--
-- Table structure for table `applicant`
--

CREATE TABLE `applicant` (
  `ID` int(11) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone` varchar(12) DEFAULT NULL,
  `PostID` int(11) DEFAULT NULL,
  `AppliedDate` datetime DEFAULT current_timestamp(),
  `Location` varchar(255) DEFAULT NULL,
  `Level` varchar(100) DEFAULT 'Fresher',
  `File_CV` varchar(255) NOT NULL,
  `Cover` longtext DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Status` enum('accept','reject','pending') DEFAULT 'pending',
  `Reason` longtext DEFAULT NULL
) ;

--
-- Dumping data for table `applicant`
--

INSERT INTO `applicant` (`ID`, `Fullname`, `Email`, `Phone`, `PostID`, `AppliedDate`, `Location`, `Level`, `File_CV`, `Cover`, `AdminID`, `Status`, `Reason`) VALUES
(1, 'James Wilson', 'james.wilson@gmail.com', '3125557890', 1, '2025-04-14 15:10:45', 'San Francisco, CA', 'Senior', 'james_wilson_cv.pdf', 'I have 7 years of experience with React and modern JavaScript frameworks. I\'ve led frontend teams at two startups and contributed to several open source projects.', NULL, 'pending', NULL),
(2, 'Sophia Chen', 'sophia.chen@outlook.com', '4155551234', 1, '2025-04-14 15:10:45', 'Oakland, CA', 'Senior', 'sophia_chen_resume.pdf', 'With 6+ years of frontend development experience focusing on React, I\'ve built and maintained large-scale applications serving millions of users.', NULL, 'pending', NULL),
(3, 'Michael Rodriguez', 'mrodriguez@yahoo.com', '4155552222', 1, '2025-04-14 15:10:45', 'San Jose, CA', 'Senior', 'michael_rodriguez_cv.pdf', 'Frontend architect with 8 years of experience. Expert in React, Redux, and optimizing web application performance.', NULL, 'pending', NULL),
(4, 'Emily Johnston', 'ejohnston@mail.com', '5105553333', 2, '2025-04-14 15:10:45', 'Mountain View, CA', 'Middle', 'emily_johnston_cv.pdf', 'Backend developer with 4 years of Python experience. Proficient in Django and AWS microservices architecture.', NULL, 'pending', NULL),
(5, 'David Kim', 'dkim@techmail.net', '4085554444', 2, '2025-04-14 15:10:45', 'San Francisco, CA', 'Middle', 'david_kim_resume.pdf', 'Full stack developer with strong backend focus. 5 years working with Python/Django and cloud infrastructure.', NULL, 'pending', NULL),
(6, 'Sarah Thompson', 'sthompson@coder.com', '9255555555', 3, '2025-04-14 15:10:45', 'Portland, OR', 'Middle', 'sarah_thompson_cv.pdf', 'DevOps engineer with expertise in Docker, Kubernetes, and AWS. Passionate about automation and CI/CD pipelines.', NULL, 'pending', NULL),
(7, 'Robert Chen', 'robert.chen@gmail.com', '7735556666', 6, '2025-04-14 15:10:45', 'Chicago, IL', 'Senior', 'robert_chen_cv.pdf', 'PMP certified project manager with 10+ years leading software development teams. Expert in Agile methodologies and team leadership.', NULL, 'pending', NULL),
(8, 'Jennifer Lopez', 'jlopez@projectpro.com', '8475557777', 6, '2025-04-14 15:10:45', 'Chicago, IL', 'Senior', 'jennifer_lopez_resume.pdf', 'Senior project manager with PMP and CSM certifications. 8 years of experience managing complex software projects.', NULL, 'pending', NULL),
(9, 'Thomas Washington', 'twashington@datasci.io', '3125558888', 7, '2025-04-14 15:10:45', 'Evanston, IL', 'Middle', 'thomas_washington_cv.pdf', 'Data scientist with MS in Computer Science and 4 years of industry experience. Expert in Python, machine learning, and NLP.', NULL, 'pending', NULL),
(10, 'Hannah Garcia', 'hgarcia@airesearch.net', '7085559999', 7, '2025-04-14 15:10:45', 'Chicago, IL', 'Middle', 'hannah_garcia_resume.pdf', 'Data scientist specializing in predictive modeling and machine learning algorithms. 3 years of experience with Python and TensorFlow.', NULL, 'pending', NULL),
(11, 'Christopher Lee', 'chris.lee@mlexperts.com', '6175551122', 10, '2025-04-14 15:10:45', 'Cambridge, MA', 'Senior', 'christopher_lee_cv.pdf', 'Machine learning engineer with PhD in Computer Science. 6 years of experience developing recommendation systems and deep learning models.', NULL, 'pending', NULL),
(12, 'Amanda Patel', 'amanda.p@airesearch.org', '8575553344', 10, '2025-04-14 15:10:45', 'Boston, MA', 'Senior', 'amanda_patel_resume.pdf', 'Senior ML engineer with expertise in computer vision and recommendation systems. Published researcher with practical industry experience.', NULL, 'pending', NULL),
(13, 'Daniel Wilson', 'dwilson@cloudarch.net', '5085555566', 11, '2025-04-14 15:10:45', 'Austin, TX', 'Senior', 'daniel_wilson_cv.pdf', 'Cloud architect with certifications in AWS, Azure, and GCP. 7+ years designing and implementing multi-cloud infrastructures.', NULL, 'pending', NULL),
(14, 'Michelle Johnson', 'mjohnson@devcloud.com', '7815557788', 11, '2025-04-14 15:10:45', 'Seattle, WA', 'Senior', 'michelle_johnson_resume.pdf', 'Experienced cloud architect with expertise in infrastructure as code and cloud security. AWS and Azure certified professional.', NULL, 'pending', NULL),
(15, 'Brian Taylor', 'btaylor@techlead.com', '5125559900', 13, '2025-04-14 15:10:45', 'Austin, TX', 'Senior', 'brian_taylor_cv.pdf', 'Engineering manager with 12 years of software development experience. Led teams of 20+ engineers and mentored junior developers.', NULL, 'pending', NULL),
(16, 'Rachel Kim', 'rkim@engineering.org', '7375551212', 13, '2025-04-14 15:10:45', 'Houston, TX', 'Senior', 'rachel_kim_resume.pdf', 'Technical leader with 10+ years in software engineering. Experience managing distributed teams and complex projects.', NULL, 'pending', NULL),
(17, 'Kevin Martinez', 'kmartinez@devstack.io', '5125553434', 14, '2025-04-14 15:10:45', 'Austin, TX', 'Middle', 'kevin_martinez_cv.pdf', 'Full stack developer with 4 years of experience in JavaScript, React, Node.js, and MongoDB. Built and maintained multiple production RESTful APIs.', NULL, 'pending', NULL),
(18, 'Olivia White', 'owhite@fullstack.dev', '5125555656', 14, '2025-04-14 15:10:45', 'San Antonio, TX', 'Middle', 'olivia_white_resume.pdf', 'Full stack developer passionate about clean code and modern web technologies. 3+ years with MERN stack development.', NULL, 'pending', NULL),
(19, 'Jason Park', 'jpark@security.net', '5125557878', 15, '2025-04-14 15:10:45', 'Dallas, TX', 'Senior', 'jason_park_cv.pdf', 'Security engineer with CISSP certification. 8 years of experience in penetration testing, security audits, and threat modeling.', NULL, 'pending', NULL),
(20, 'Alicia Gomez', 'agomez@cybersec.com', '7135559090', 15, '2025-04-14 15:10:45', 'Austin, TX', 'Senior', 'alicia_gomez_resume.pdf', 'Cybersecurity expert with focus on application security. Experience in penetration testing and implementing security best practices.', NULL, 'pending', NULL),
(21, 'Eric Johnson', 'eric.j@fintech.net', '2125551234', 19, '2025-04-14 15:10:45', 'New York, NY', 'Middle', 'eric_johnson_cv.pdf', 'Financial analyst programmer with 4 years of experience developing trading algorithms using Python. Background in quantitative finance.', NULL, 'pending', NULL),
(22, 'Tina Shah', 'tshah@quant.org', '9175552345', 19, '2025-04-14 15:10:45', 'Jersey City, NJ', 'Middle', 'tina_shah_resume.pdf', 'Programmer analyst with strong background in financial markets. Experience with algorithmic trading and risk analysis systems.', NULL, 'pending', NULL),
(23, 'Marcus Brown', 'mbrown@blockchain.dev', '6465553456', 20, '2025-04-14 15:10:45', 'Brooklyn, NY', 'Senior', 'marcus_brown_cv.pdf', 'Blockchain developer with 5+ years experience in Ethereum ecosystem. Created multiple smart contracts and DeFi applications.', NULL, 'pending', NULL),
(24, 'Natalie Wong', 'nwong@crypto.io', '3475554567', 20, '2025-04-14 15:10:45', 'New York, NY', 'Senior', 'natalie_wong_resume.pdf', 'Senior blockchain developer specializing in smart contracts and DeFi protocols. Contributed to several successful cryptocurrency projects.', NULL, 'pending', NULL),
(25, 'Victor Nguyen', 'vnguyen@solutions.arch', '2065555678', 23, '2025-04-14 15:10:45', 'Seattle, WA', 'Senior', 'victor_nguyen_cv.pdf', 'Solution architect with 9 years of experience designing enterprise systems. Expert in microservices architecture and distributed systems.', NULL, 'pending', NULL),
(26, 'Jessica Miller', 'jmiller@enterprise.tech', '2535556789', 23, '2025-04-14 15:10:45', 'Bellevue, WA', 'Senior', 'jessica_miller_resume.pdf', 'Enterprise architect with experience leading digital transformation projects. Strong background in cloud-native architectures.', NULL, 'pending', NULL),
(27, 'Derek Adams', 'dadams@angulardev.com', '4255557890', 24, '2025-04-14 15:10:45', 'Portland, OR', 'Middle', 'derek_adams_cv.pdf', 'Frontend developer with 4 years of Angular experience. Expert in TypeScript, RxJS, and state management with NgRx.', NULL, 'pending', NULL),
(28, 'Lisa Jackson', 'ljackson@frontend.net', '5035558901', 24, '2025-04-14 15:10:45', 'Seattle, WA', 'Middle', 'lisa_jackson_resume.pdf', 'Angular specialist with strong TypeScript skills. 5 years of experience building complex single-page applications.', NULL, 'pending', NULL),
(29, 'Paul Johnson', 'pjohnson@webdev.tech', '2065559012', 24, '2025-04-14 15:10:45', 'Tacoma, WA', 'Middle', 'paul_johnson_cv.pdf', 'Frontend developer specializing in Angular and component-based architecture. Experience with large-scale enterprise applications.', NULL, 'pending', NULL),
(30, 'Grace Lee', 'glee@reliability.eng', '5035550123', 26, '2025-04-14 15:10:45', 'Portland, OR', 'Senior', 'grace_lee_cv.pdf', 'Site reliability engineer with 6 years of experience. Expert in monitoring systems, incident response, and performance optimization.', NULL, 'pending', NULL),
(31, 'Trevor Wilson', 'twilson@devops.cloud', '5415551234', 26, '2025-04-14 15:10:45', 'Eugene, OR', 'Senior', 'trevor_wilson_resume.pdf', 'SRE focused on building resilient systems. Experience with observability tools and implementing SLOs/SLIs for critical services.', NULL, 'pending', NULL),
(32, 'Natasha Rodriguez', 'nrodriguez@golang.dev', '3035552345', 28, '2025-04-14 15:10:45', 'Denver, CO', 'Middle', 'natasha_rodriguez_cv.pdf', 'Backend developer with 3 years of experience in Go. Built high-performance microservices and distributed systems.', NULL, 'pending', NULL),
(33, 'Samuel Kim', 'skim@gobackend.net', '7205553456', 28, '2025-04-14 15:10:45', 'Boulder, CO', 'Middle', 'samuel_kim_resume.pdf', 'Go developer passionate about building efficient, scalable services. Experience with containerization and Kubernetes.', NULL, 'pending', NULL),
(34, 'Priya Sharma', 'psharma@microserv.io', '3035554567', 28, '2025-04-14 15:10:45', 'Denver, CO', 'Middle', 'priya_sharma_cv.pdf', 'Backend engineer with Go expertise. Developed RESTful APIs and gRPC services for distributed systems.', NULL, 'pending', NULL),
(35, 'Jordan Taylor', 'jtaylor@mlops.ai', '7205555678', 29, '2025-04-14 15:10:45', 'Fort Collins, CO', 'Middle', 'jordan_taylor_cv.pdf', 'MLOps engineer with experience streamlining machine learning workflows. Expert in ML pipelines, containerization, and cloud deployment.', NULL, 'pending', NULL),
(36, 'Carlos Mendez', 'cmendez@aiops.dev', '3035556789', 29, '2025-04-14 15:10:45', 'Denver, CO', 'Middle', 'carlos_mendez_resume.pdf', 'Machine learning engineer focused on operationalizing AI. Experience with model deployment and production ML systems.', NULL, 'pending', NULL),
(37, 'Rebecca Chang', 'rchang@fullstack.io', '5125557070', 14, '2025-04-14 15:10:45', 'Austin, TX', 'Middle', 'rebecca_chang_cv.pdf', 'Full stack JavaScript developer with expertise in React, Node.js and GraphQL. 3+ years building web applications.', NULL, 'pending', NULL),
(38, 'Tyler Johnson', 'tjohnson@reactdev.com', '4155558080', 1, '2025-04-14 15:10:45', 'San Francisco, CA', 'Senior', 'tyler_johnson_resume.pdf', 'Frontend specialist with 7 years of React experience. Focused on component architecture and state management.', NULL, 'pending', NULL),
(39, 'Aisha Patel', 'apatel@godev.net', '3035559090', 28, '2025-04-14 15:10:45', 'Denver, CO', 'Middle', 'aisha_patel_cv.pdf', 'Go developer with strong focus on performance and scalability. 4 years experience with microservices architecture.', NULL, 'pending', NULL);

--
-- Triggers `applicant`
--
DELIMITER $$
CREATE TRIGGER `trg_decrement_applicants_apply` AFTER DELETE ON `applicant` FOR EACH ROW BEGIN
  UPDATE Post
  SET Applicants_apply = Applicants_apply - 1
  WHERE ID = OLD.PostID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_increment_applicants_apply` AFTER INSERT ON `applicant` FOR EACH ROW BEGIN
  UPDATE Post
  SET Applicants_apply = Applicants_apply + 1
  WHERE ID = NEW.PostID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `PostID` int(11) DEFAULT NULL,
  `Type` enum('approved','disapproved') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`ID`, `UserID`, `Description`, `PostID`, `Type`) VALUES
(1, 1, 'Your job posting \"Senior Frontend Developer\" has been approved and is now live.', 1, 'approved'),
(2, 1, 'Your job posting \"Backend Engineer\" has been approved and is now live.', 2, 'approved'),
(3, 1, 'Your job posting \"DevOps Specialist\" has been approved and is now live.', 3, 'approved'),
(4, 1, 'Your job posting \"QA Engineer\" has been disapproved. Reason: Job description lacks specific requirements and responsibilities. Please provide more details about day-to-day tasks and required qualifications.', 5, 'disapproved'),
(5, 2, 'Your job posting \"Project Manager\" has been approved and is now live.', 6, 'approved'),
(6, 2, 'Your job posting \"Data Scientist\" has been approved and is now live.', 7, 'approved'),
(7, 2, 'Your job posting \"Technical Writer\" has been disapproved. Reason: Salary range appears below market standards for the required experience level. Please review and adjust compensation package.', 9, 'disapproved'),
(8, 3, 'Your job posting \"Machine Learning Engineer\" has been approved and is now live.', 10, 'approved'),
(9, 3, 'Your job posting \"Cloud Architect\" has been approved and is now live.', 11, 'approved'),
(10, 4, 'Your job posting \"Software Engineering Manager\" has been approved and is now live.', 13, 'approved'),
(11, 4, 'Your job posting \"Full Stack Developer\" has been approved and is now live.', 14, 'approved'),
(12, 4, 'Your job posting \"Security Engineer\" has been approved and is now live.', 15, 'approved'),
(13, 4, 'Your job posting \"Product Manager\" has been disapproved. Reason: The job posting conflicts with another active role in your company. Please clarify team structure and reporting relationships.', 17, 'disapproved'),
(14, 7, 'Your job posting \"Financial Analyst Programmer\" has been approved and is now live.', 19, 'approved'),
(15, 7, 'Your job posting \"Blockchain Developer\" has been approved and is now live.', 20, 'approved'),
(16, 7, 'Your job posting \"Data Engineer\" has been disapproved. Reason: Missing information about required years of experience. Please specify minimum qualifications more clearly.', 22, 'disapproved'),
(17, 8, 'Your job posting \"Solution Architect\" has been approved and is now live.', 23, 'approved'),
(18, 8, 'Your job posting \"Frontend Developer (Angular)\" has been approved and is now live.', 24, 'approved'),
(19, 9, 'Your job posting \"Site Reliability Engineer\" has been approved and is now live.', 26, 'approved'),
(20, 10, 'Your job posting \"Backend Developer (Go)\" has been approved and is now live.', 28, 'approved'),
(21, 10, 'Your job posting \"Machine Learning Ops Engineer\" has been approved and is now live.', 29, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Postname` varchar(255) NOT NULL,
  `Company` varchar(255) DEFAULT NULL,
  `Applicants_max` int(11) DEFAULT NULL CHECK (`Applicants_max` > 0),
  `Applicants_apply` int(11) DEFAULT 0,
  `Location` varchar(255) NOT NULL,
  `Salary` double NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `Due` datetime NOT NULL,
  `Level` varchar(100) DEFAULT 'Fresher',
  `Description` longtext DEFAULT NULL,
  `File_description` varchar(255) DEFAULT NULL,
  `Status` enum('pending','disapproved','approved') DEFAULT 'pending',
  `Reason` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`ID`, `AdminID`, `UserID`, `Postname`, `Company`, `Applicants_max`, `Applicants_apply`, `Location`, `Salary`, `CreatedDate`, `Due`, `Level`, `Description`, `File_description`, `Status`, `Reason`) VALUES
(1, 5, 1, 'Senior Frontend Developer', 'TechCo Solutions', 10, 4, 'San Francisco, CA', 12000000, '2024-03-15 09:30:00', '2024-05-15 23:59:59', 'Senior', 'Looking for an experienced frontend developer with 5+ years of React expertise. Must have experience with modern JavaScript frameworks and responsive design principles.', 'job_details_frontend.pdf', 'approved', NULL),
(2, 5, 1, 'Backend Engineer', 'TechCo Solutions', 8, 2, 'San Francisco, CA', 13000000, '2024-03-20 11:45:00', '2024-05-20 23:59:59', 'Middle', 'Seeking a talented backend engineer with strong Python and Django skills. Experience with AWS and microservices architecture is a plus.', 'backend_job_spec.pdf', 'approved', NULL),
(3, 6, 1, 'DevOps Specialist', 'TechCo Solutions', 5, 1, 'Remote', 11500000, '2024-03-25 14:20:00', '2024-05-25 23:59:59', 'Middle', 'Join our DevOps team to help streamline our CI/CD pipeline. Experience with Docker, Kubernetes, and AWS is required.', 'devops_role.pdf', 'approved', NULL),
(4, NULL, 1, 'UX/UI Designer', 'TechCo Solutions', 3, 0, 'San Francisco, CA', 9500000, '2024-04-01 10:00:00', '2024-06-01 23:59:59', 'Junior', 'Creative designer needed to help craft beautiful, intuitive user interfaces. Proficiency in Figma and Adobe Creative Suite required.', 'designer_job_desc.pdf', 'pending', NULL),
(5, 6, 1, 'QA Engineer', 'TechCo Solutions', 4, 0, 'Remote', 8500000, '2024-04-05 13:15:00', '2024-06-05 23:59:59', 'Junior', 'Detail-oriented QA engineer with automation testing experience. Familiarity with Selenium and Jest preferred.', 'qa_position.pdf', 'disapproved', 'Job description lacks specific requirements and responsibilities. Please provide more details about day-to-day tasks and required qualifications.'),
(6, 5, 2, 'Project Manager', 'ABC Corporation', 6, 2, 'Chicago, IL', 11000000, '2024-03-10 08:45:00', '2024-05-10 23:59:59', 'Senior', 'Experienced project manager to lead our software development team. PMP certification and Agile methodology experience required.', 'pm_job.pdf', 'approved', NULL),
(7, 5, 2, 'Data Scientist', 'ABC Corporation', 4, 2, 'Chicago, IL', 12500000, '2024-03-18 09:30:00', '2024-05-18 23:59:59', 'Middle', 'Looking for a data scientist with strong Python and machine learning expertise. Experience with NLP and predictive modeling desired.', 'data_scientist_role.pdf', 'approved', NULL),
(8, NULL, 2, 'Business Analyst', 'ABC Corporation', 5, 0, 'Remote', 9000000, '2024-03-26 11:00:00', '2024-05-26 23:59:59', 'Junior', 'Business analyst to help bridge the gap between business needs and technical solutions. SQL and data visualization skills required.', 'ba_position.pdf', 'pending', NULL),
(9, 6, 2, 'Technical Writer', 'ABC Corporation', 2, 0, 'Chicago, IL', 7500000, '2024-04-02 13:30:00', '2024-06-02 23:59:59', 'Junior', 'Technical writer to create user documentation, API guides, and internal technical specifications. Experience with documentation tools required.', 'tech_writer.pdf', 'disapproved', 'Salary range appears below market standards for the required experience level. Please review and adjust compensation package.'),
(10, 5, 3, 'Machine Learning Engineer', 'Talent Finders Inc.', 7, 2, 'Boston, MA', 14000000, '2024-03-12 10:15:00', '2024-05-12 23:59:59', 'Senior', 'Machine learning expert needed to develop and optimize our AI-powered recommendation systems. Deep learning experience required.', 'ml_engineer.pdf', 'approved', NULL),
(11, 6, 3, 'Cloud Architect', 'Talent Finders Inc.', 4, 2, 'Remote', 15000000, '2024-03-22 09:45:00', '2024-05-22 23:59:59', 'Senior', 'Experienced cloud architect to design and implement our multi-cloud infrastructure. AWS, Azure, and GCP knowledge required.', 'cloud_architect.pdf', 'approved', NULL),
(12, NULL, 3, 'Mobile Developer (iOS)', 'Talent Finders Inc.', 5, 0, 'Boston, MA', 10500000, '2024-03-30 14:00:00', '2024-05-30 23:59:59', 'Middle', 'iOS developer with Swift expertise needed for our mobile app team. Experience with SwiftUI and app store deployment required.', 'ios_dev.pdf', 'pending', NULL),
(13, 5, 4, 'Software Engineering Manager', 'DevWorks', 3, 2, 'Austin, TX', 16000000, '2024-03-05 11:30:00', '2024-05-05 23:59:59', 'Senior', 'Engineering manager to lead our development team of 15+ developers. Strong technical leadership and mentoring skills required.', 'eng_manager.pdf', 'approved', NULL),
(14, 5, 4, 'Full Stack Developer', 'DevWorks', 10, 3, 'Austin, TX', 11500000, '2024-03-14 13:00:00', '2024-05-14 23:59:59', 'Middle', 'Full stack developer proficient in JavaScript, React, Node.js, and MongoDB. Experience with RESTful APIs required.', 'fullstack_dev.pdf', 'approved', NULL),
(15, 6, 4, 'Security Engineer', 'DevWorks', 5, 2, 'Remote', 13000000, '2024-03-24 10:30:00', '2024-05-24 23:59:59', 'Senior', 'Security engineer to help protect our systems and customer data. Experience with penetration testing and security audits required.', 'security_eng.pdf', 'approved', NULL),
(16, NULL, 4, 'Database Administrator', 'DevWorks', 4, 0, 'Austin, TX', 11000000, '2024-04-03 09:15:00', '2024-06-03 23:59:59', 'Middle', 'DBA with PostgreSQL expertise needed to optimize and maintain our databases. Performance tuning and backup/recovery experience required.', 'dba_role.pdf', 'pending', NULL),
(17, 6, 4, 'Product Manager', 'DevWorks', 3, 0, 'Austin, TX', 12000000, '2024-04-07 11:45:00', '2024-06-07 23:59:59', 'Senior', 'Product manager to lead our new SaaS product development. Experience with B2B software products required.', 'product_mgr.pdf', 'disapproved', 'The job posting conflicts with another active role in your company. Please clarify team structure and reporting relationships.'),
(18, NULL, 4, 'Technical Support Specialist', 'DevWorks', 8, 0, 'Remote', 7000000, '2024-04-10 14:30:00', '2024-06-10 23:59:59', 'Junior', 'Customer-focused support specialist to troubleshoot technical issues for our enterprise customers. Strong problem-solving skills required.', 'tech_support.pdf', 'pending', NULL),
(19, 5, 7, 'Financial Analyst Programmer', 'Finance Plus', 6, 2, 'New York, NY', 9500000, '2024-03-08 09:00:00', '2024-05-08 23:59:59', 'Middle', 'Programmer with financial domain knowledge to develop our trading algorithms. Experience with Python and quantitative analysis required.', 'fin_analyst_prog.pdf', 'approved', NULL),
(20, 6, 7, 'Blockchain Developer', 'Finance Plus', 4, 2, 'Remote', 14000000, '2024-03-19 10:45:00', '2024-05-19 23:59:59', 'Senior', 'Blockchain expert to develop and maintain our DeFi applications. Experience with Ethereum, Solidity, and smart contracts required.', 'blockchain_dev.pdf', 'approved', NULL),
(21, NULL, 7, 'Cybersecurity Analyst', 'Finance Plus', 5, 0, 'New York, NY', 12000000, '2024-03-28 13:00:00', '2024-05-28 23:59:59', 'Middle', 'Security analyst to protect our financial systems from cyber threats. Experience with financial compliance (SOX, PCI) preferred.', 'cybersec_analyst.pdf', 'pending', NULL),
(22, 5, 7, 'Data Engineer', 'Finance Plus', 4, 0, 'New York, NY', 11000000, '2024-04-08 11:30:00', '2024-06-08 23:59:59', 'Middle', 'Data engineer to design and maintain our data pipelines and warehouses. Experience with Apache Spark and Airflow required.', 'data_eng.pdf', 'disapproved', 'Missing information about required years of experience. Please specify minimum qualifications more clearly.'),
(23, 6, 8, 'Solution Architect', 'Global Technologies', 5, 2, 'Seattle, WA', 14500000, '2024-03-07 14:15:00', '2024-05-07 23:59:59', 'Senior', 'Solution architect to design enterprise-level systems for our clients. Experience with microservices and distributed systems required.', 'solution_arch.pdf', 'approved', NULL),
(24, 5, 8, 'Frontend Developer (Angular)', 'Global Technologies', 7, 3, 'Remote', 10000000, '2024-03-17 12:30:00', '2024-05-17 23:59:59', 'Middle', 'Angular developer with strong TypeScript skills. Experience with NgRx and RxJS highly desired.', 'angular_dev.pdf', 'approved', NULL),
(25, NULL, 8, 'AI Research Scientist', 'Global Technologies', 3, 0, 'Seattle, WA', 16000000, '2024-03-27 09:45:00', '2024-05-27 23:59:59', 'Senior', 'AI researcher to explore cutting-edge machine learning techniques. PhD in computer science or related field preferred.', 'ai_scientist.pdf', 'pending', NULL),
(26, 5, 9, 'Site Reliability Engineer', 'InnovaTech', 4, 2, 'Portland, OR', 12500000, '2024-03-09 11:00:00', '2024-05-09 23:59:59', 'Senior', 'SRE to ensure the reliability and performance of our cloud infrastructure. Experience with observability tools and incident response required.', 'sre_job.pdf', 'approved', NULL),
(27, NULL, 9, 'Software Development Intern', 'InnovaTech', 10, 0, 'Portland, OR', 4500000, '2024-03-29 10:00:00', '2024-05-29 23:59:59', 'Intern', 'Summer internship for computer science students. Knowledge of Java or Python required. Great opportunity to learn from experienced developers.', 'intern_dev.pdf', 'pending', NULL),
(28, 6, 10, 'Backend Developer (Go)', 'Cloud Services Network', 6, 4, 'Denver, CO', 12000000, '2024-03-06 13:45:00', '2024-05-06 23:59:59', 'Middle', 'Go developer to build high-performance microservices. Experience with distributed systems and containerization required.', 'go_dev.pdf', 'approved', NULL),
(29, 5, 10, 'Machine Learning Ops Engineer', 'Cloud Services Network', 4, 2, 'Remote', 13500000, '2024-03-16 09:15:00', '2024-05-16 23:59:59', 'Middle', 'MLOps engineer to streamline our machine learning workflows. Experience with ML pipelines and deployment required.', 'mlops_eng.pdf', 'approved', NULL),
(30, NULL, 10, 'Technical Product Owner', 'Cloud Services Network', 3, 0, 'Denver, CO', 11500000, '2024-03-31 12:00:00', '2024-05-31 23:59:59', 'Senior', 'Technical product owner with strong engineering background to bridge business and technical teams. Agile certification preferred.', 'tech_po.pdf', 'pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_`
--

CREATE TABLE `user_` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Password` text NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `CompanyName` varchar(255) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `NumPost` int(11) DEFAULT NULL,
  `NumApplicant` int(11) DEFAULT NULL,
  `Role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_`
--

INSERT INTO `user_` (`ID`, `Username`, `Password`, `Email`, `CompanyName`, `Avatar`, `NumPost`, `NumApplicant`, `Role`) VALUES
(1, 'techrecruiter1', '$2y$10$mjrcWLIYgCTEmsL/bjp4e.cAT6bJryuLIaQwsu52F355QNRXqXWVW', 'recruiter1@techco.com', 'TechCo Solutions', 'avatar1.jpg', 5, 28, 'user'),
(2, 'hrmanager_abc', '$2y$10$CwVh1GySsq4MXOkFsH.onOc4PMvDu6R/kEcBenrETCrA5pubxkph6', 'hr@abccorp.com', 'ABC Corporation', 'avatar2.jpg', 4, 15, 'user'),
(3, 'talentscout', '$2y$10$QieJK.75Q0koTbv3bWAGteWiWlykpZqztdZ./Hy.0wufVxhn.evjO', 'scout@talentfinders.com', 'Talent Finders Inc.', 'avatar3.jpg', 3, 12, 'user'),
(4, 'devhiring', '$2y$10$afuyBXvL99Ve4mEl57TFEuSYFcwi4vkB9Zmvfvts1PZ19zWeeLVfq', 'hiring@devworks.com', 'DevWorks', 'avatar4.jpg', 6, 32, 'user'),
(5, 'admin_sarah', '$2y$10$eKcPPsjgeC3y0wqSHqnFm.3L.eWoD0WqdPu6c/mBr/YciGhtps47q', 'sarah@jobhunter.com', NULL, 'admin1.jpg', 0, 0, 'admin'),
(6, 'admin_john', '$2y$10$nfbG1IWBKfXMD0yg2IuXuOPDQ6iiQbT1yZkKkDoIvDLDMwhTj2hui', 'john@jobhunter.com', NULL, 'admin2.jpg', 0, 0, 'admin'),
(7, 'financerecruiter', '$2y$10$us6vNcjDv1PVbcmXp98H/u2FP5HK4Y4RmmGFHPCB5/23Ut4LJyoTe', 'recruit@financeplus.com', 'Finance Plus', 'avatar5.jpg', 4, 18, 'user'),
(8, 'globalhires', '$2y$10$DZW4VvlelNnmZ9xgY5B/2efW1Wq60CkKhzsvl1mzb7ftyA/dOZqb2', 'hiring@globaltech.com', 'Global Technologies', 'avatar6.jpg', 3, 9, 'user'),
(9, 'innovatestaff', '$2y$10$uEZkzPp8Q3hWaz0tHEEhMe9D02FpUmQXhwWoMXXoIzz/gs/AfVsF.', 'staff@innovatech.com', 'InnovaTech', 'avatar7.jpg', 2, 7, 'user'),
(10, 'cloudrecruit', '$2y$10$Yr/zk8qk6ufuJNGBup10Oep5yc.dPMA0KQdhS7C.PpmLAfVqB1zNS', 'jobs@cloudservices.net', 'Cloud Services Network', 'avatar8.jpg', 3, 14, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant`
--
ALTER TABLE `applicant`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_applicants_post` (`PostID`),
  ADD KEY `fk_applicants_admin` (`AdminID`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_noti_user` (`UserID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_post_company` (`UserID`);

--
-- Indexes for table `user_`
--
ALTER TABLE `user_`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `CompanyName` (`CompanyName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant`
--
ALTER TABLE `applicant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_`
--
ALTER TABLE `user_`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant`
--
ALTER TABLE `applicant`
  ADD CONSTRAINT `fk_applicants_admin` FOREIGN KEY (`AdminID`) REFERENCES `user_` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_applicants_post` FOREIGN KEY (`PostID`) REFERENCES `post` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_noti_user` FOREIGN KEY (`UserID`) REFERENCES `user_` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_company` FOREIGN KEY (`UserID`) REFERENCES `user_` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
