-- Table structure for Young Athletes Program (YAP) content management

CREATE TABLE `yap_content` (
  `id` int(11) NOT NULL,
  `hero_image` varchar(500) DEFAULT '../assets/images/yap-hero.jpg',
  `hero_title` varchar(255) DEFAULT 'Young Athletes Program (YAP)',
  `description_text` longtext NOT NULL,
  `testimonial_text` longtext DEFAULT NULL,
  `testimonial_author` varchar(255) DEFAULT NULL,
  `testimonial_location` varchar(255) DEFAULT NULL,
  `resources_title` varchar(255) DEFAULT 'Resources for YAP',
  `resources_description` text DEFAULT NULL,
  `resources_button_text` varchar(100) DEFAULT 'LEARN MORE',
  `resources_button_link` varchar(255) DEFAULT '../src/yap-lm.html',
  `resources_background_image` varchar(500) DEFAULT '../assets/images/yap-lm-hero-hf.jpg',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `yap_content`
--
ALTER TABLE `yap_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `yap_content`
--
ALTER TABLE `yap_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Default content for YAP
--
INSERT INTO `yap_content` (`description_text`, `testimonial_text`, `testimonial_author`, `testimonial_location`) VALUES 
('Special Olympics Young Athletes is an early childhood play program for children with and without intellectual disabilities, ages 2 to 7 years old. Young Athletes introduces basic sport skills, like running, kicking and throwing. Young Athletes offers families, teachers, caregivers and people from the community the chance to share the joy of sports with all children.

Young Athletes provides children of all abilities the same opportunities to advance in core developmental milestones. Children learn how to play with others and develop important skills for learning. Children also learn to share, take turns and follow directions. These skills help children in family, community and school activities.

Young Athletes is a fun way for children to stay active and establish healthy habits for the future. It is important to teach children healthy habits while they are young. This can set the stage for a life of physical activity, friendships and learning. Young Athletes is easy to do and fun for all. It can be done at home, in schools or in the community using the Young Athletes Activity Guide and basic equipment. Through Young Athletes, all children, their families and people in the community can be a part of an inclusive team.

Young Athletes welcomes children and their families into the Special Olympics Sarawak.

<ul>
<li><strong>Motor Skills:</strong> Children with intellectual disabilities who took part in Young Athletes developed motor skills more than twice as fast as others who did not take part.</li>
<li><strong>Social, Emotional and Learning Skills:</strong> Parents and teachers of children who took part in the Young Athletes curriculum said the children learned skills that they will use in pre-primary school.</li>
<li><strong>Expectations:</strong> Family members say that Young Athletes raised their hopes for their child''s future.</li>
<li><strong>Sport Readiness:</strong> Young Athletes helps children get ready to take part in sports when they are older.</li>
<li><strong>Acceptance:</strong> Inclusive play helps children without a disability to better understand and accept others.</li>
</ul>

For more information about Young Athletes, <a href="../src/yap-lm.html" style="color: #e63946; text-decoration: none;">visit our Young Athletes Program (YAP) Resources page.</a>

Studies show that after two months of participation in Young Athletes, children with intellectual disabilities experienced a seven month gain in motor skills, representing an improvement at twice the rate of children with intellectual disabilities who have not participated in the program.

Children with intellectual disabilities participating in Young Athletes exhibited greater increases in communication, social, and daily living skills, compared to children with ID not participating in Young Athletes.

Children and families participating in a comprehensive Child and Family Health program, inclusive of Young Athletes, Family Health Forum, and Healthy Young Athletes Pediatric Screening, experienced improvements across the whole family, positively impacting child development and efficacy and empowerment for parents and caregivers.',

'"When my baby was born and I learned he had an intellectual disability, I felt lost, unsure of what the future would hold. But at Young Athletes Program, I see him so full of joy — running, laughing, and connecting with others. It''s such a beautiful sight to witness, and it fills me with hope, reminding me that one day, he might just be able to stand on his own, stronger than I could have ever imagined."',

'SARAH, MOTHER OF A YOUNG ATHLETES IN KUCHING',

'KUCHING');