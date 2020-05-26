<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\FormGenerator\ContactUsFormGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscoverController extends BaseController
{
    /**
     * @Route(path="discover/safety", name="discover_safety")
     */
    public function safety()
    {
        $safetyTips = [
            ['title' => 'Learn Common Travel Scams', 'description' => "Wherever you go in the world, you’ll always find people ready to trick you out of your hard-earned cash. If you’re lucky, they’ll be kinda obvious – but there are plenty of craftier, professional con-artists out there too."],
            ['title' => 'Write Down Emergency Info', 'description' => "If disaster strikes, you might not have time to search for numbers for local police or ambulance services, or directions to the nearest embassy for your country. You may also be too stressed and panicky to think straight.\nDon’t put yourself in that position. Instead, record that information in advance, and create an “Emergency Plan” for you to follow if things go badly. Save it on your phone somewhere (I use the Evernote App).\nI also recommend you write it down on a small card or sheet of paper, get it laminated (easily done at your local office supply store) to protect it from moisture, and keep it in your wallet/purse.\nThat way, if something goes wrong out there, you’ll always know exactly who to call and where to go for help."],
            ['title' => 'Check The State Department Website', 'description' => "The U.S. Department of State has a page for every country in the world, where it lists all known difficulties and current threats to the safety of visitors.\nHowever, a big caveat for this one: it’s the State Department’s job to warn you about everything that could go wrong, which is sometimes different to what is likely to go wrong.\nThis means their advice is generally on the hyper-cautious side. Factor that in, while you dig up more on-the-ground information.\nBut researching travel warnings will give you a general idea of what’s going on in the country you’re visiting, and specific problem areas you may want to avoid.\nFor example, just because certain parts of Thailand or Mexico have problems, doesn’t mean you should completely avoid those countries."],
            ['title' => 'Lock Up Your Valuables', 'description' => "Putting aside the fact that traveling with anything super valuable is usually a bad idea, there will always be something you absolutely cannot afford to have stolen. I travel with a lot of expensive camera gear for example.\nYour job is to minimize the easy opportunities for theft.\nFirstly, know that most travel backpacks aren’t very secure. It’s easy to feel that a zipped, even locked bag is a sufficient deterrent to any thief, and doze off next to it. Waking up to find someone’s slashed a hole in the side!\nUnless it’s a slash-proof backpack, the material can be cut or torn by anyone determined enough. Many zippers can be forced open with sharp objects like a writing pen.\nAlways be aware of your valuables, and try to keep an eye on them in such a way that it would be impossible for someone to steal without you knowing. I’ll use my backpack as a pillow on train/bus routes that have a reputation for theft, and will sometimes lock it to a seat using a thin cable like this.\nSecondly, call your accommodation to ask about secure storage options like a room safe, lockers, or a locked storage area. Carry your own locker padlock when staying at backpacking hostels."],
            ['title' => 'Get Travel Insurance', 'description' => "You never think you need it, until you do. If you’re really worried about the safety of yourself and your gear while you travel, you can almost completely relax if you have some good insurance."],
            ['title' => 'Ask Locals For Advice', 'description' => "If you really want to know which neighborhoods are safe and which might be sketchy, ask a local resident of the area.\nMost locals are friendly, and will warn you about straying into dangerous areas. On the other hand, if a stranger offers up advice, it’s also wise to get a second opinion – just in case they don’t really know what they’re talking about but simply wanted to help (or worse, are trying to scam you).\nTaxi drivers can be hit or miss in this regard. Some can be excellent sources for good information, others are miserable assholes who might actually lead you into trouble.\nI’ve found that hostel or hotel front desk workers are generally pretty good sources for local advice.\nDon’t be afraid to ask them which parts of the city to avoid, how much taxi fares should cost, and where to find a great place to eat!"],
            ['title' => 'Register With Your Embassy', 'description' => "That way if an emergency happens, like a natural disaster or terrorist attack, the local embassy can get a hold of you quickly to share important information or help with evacuation."],
            ['title' => 'Email Your Itinerary To Friends/Family', 'description' => "Once you’ve worked out where you’re going and when, make sure someone else knows too."],
            ['title' => 'Don’t Share Too Much With Strangers', 'description' => "If you’re ever tempted to make your itinerary more public, say in a Facebook post, just remember it can be a roadmap of your movements – just the sort of thing someone with ill-intentions would love to know."],
            ['title' => 'Be Aware Of Your Clothing', 'description' => "When it comes to travel, the wrong clothes scream “TOURIST” and make you a target for scammers, thieves and worse. The less obviously a visitor you look, the less attention you’ll get from the wrong kind of people."],
            ['title' => 'Splurge On Extra Safety', 'description' => "If you’re traveling as a budget backpacker, like I was, it can be tempting to save as much money as possible with the cheapest accommodation, the cheapest flights, the cheapest activities."],
            ['title' => 'Stay “Tethered” To Your Bag', 'description' => "Most quick snatch-and-run type robberies happen because the thief can do it easily, and has time to get away. Therefore, anything that slows them down will help prevent it in the first place."],
            ['title' => 'Learn Basic Self-Defense', 'description' => "You don’t need black-belt skills, but joining a few self defense classes is a worthwhile investment in your personal safety. Some good street-effective styles to consider are Krav Maga or Muay Thai."],
            ['title' => 'Project Situational Awareness', 'description' => "Keep your head up, stay alert, and aware of you’re surroundings. When you’re confident, potential attackers can sense it through your body language and eye contact."],
            ['title' => 'Tell Your Bank Where You’re Going', 'description' => "Imagine the agony of doing absolutely everything right and keeping yourself perfectly safe and secure – only to have your trip ruined because your bank thinks you’re the thief, and locks down all your cards.\nIf this happens and you’re lucky, you’ll be asked security questions to determine your identity. The rest of the time, you’ll get a notification from the bank’s fraud detection team that irregular activity has been recorded on your card, and they’ve put a hold on all transactions until the situation is resolved – which might take days.\nThe solution is simple. Most online banking services have a facility for letting the bank or credit card provider know about your upcoming travels. Make sure you use it, shortly before leaving – and keep them in the loop if your travel plans change.\nI also recommend using your debit card at the airport ATM machine as soon as you arrive in a new country, as this also helps let the bank know you’re traveling."],
            ['title' => 'Hide Emergency Cash', 'description' => "While it’s good to do everything you can to prevent worst case scenarios – it’s equally smart to assume it’ll happen and plan ahead for it. This is the thinking behind having an emergency stash of funds, stored in a safe place."],
            ['title' => 'Food & Water Safety', 'description' => "After traveling extensively the last 7 years, to over 50 countries, eating all kinds of weird stuff, I’ve only had food poisoning a couple of times.\nDon’t be scared of the food when you travel! In fact, eating strange new foods can be a highlight for many people on their adventures around the world."],
            ['title' => 'Use ATMs Wisely', 'description' => "You may have been told to cover your hand when keying in your PIN number at an ATM. That’s good advice worth following, both for others looking over your shoulder, as well as hidden cameras trying to record your pin.\nAlways take a close look at ATM machines before you use them. Pull on the card reader a bit. Does it have any questionable signs of tampering? If so, go into the bank and get someone to come out and check it (and then use another machine, regardless of what happens).\nIf an ATM machine appears to have eaten your card, run a finger along the card slot to see if you feel anything protruding. The “Lebanese Loop” is a trick where a thin plastic sleeve captures your card (preventing the machine from reading it) – then as soon as you walk away, a thief yanks it out and runs off with your card.\nAnother overlooked factor is where other people are when you’re at the machine. Can someone peer over your shoulder? Are they close enough they could grab the cash and run off?\nIf so, use another ATM elsewhere. Better safe than sorry! Never let anyone “help” you with your transaction either."],
            ['title' => 'Stop Using Your Back Pocket', 'description' => "It’s the first place any pickpocket will check – and short of putting a loaded mousetrap in there (not recommended if you forget and sit down), the best way to deal with the dangers of having a back pocket is to never use it…\nAnd if putting money in the back pocket of your pants is a habit you can’t seem to break, grab some needle and thread and sew it shut!"],
            ['title' => 'Travel In Numbers', 'description' => "The more people around you, the more eyeballs are on your valuables – and the more legs are available for running after thieves.\nA group is also a much more intimidating physical presence, which helps ward off predators of all kinds. It will help to keep you safer than trying to go it alone in a foreign country.\nIf you’re traveling solo, consider making some new friends and go exploring together."],
            ['title' => 'Pack A First Aid Kit', 'description' => "Injuries can happen when you travel abroad, not matter how careful you are. That’s why traveling with a basic first aid kit is always a good idea.\nYou don’t need to go crazy and bring your own needles and scalpels, but stocking the basics to treat cuts, sprains, stomach issues, and burns can help if you or people around you may need them."],
            ['title' => 'Stay (Relatively) Sober', 'description' => "Getting too drunk or high when you travel is almost always unacceptably risky. If you’re wasted, you’re not present, and anything could be happening around you (or to you).\nI’m not saying don’t enjoy yourself. Hell I have plenty over the years! Just do it responsibly, stay hyper-aware of how much you’re consuming, keep hydrated & fed, and make sure you don’t lose control of the situation.\nHarder drugs are especially risky — it’s a good way to get in trouble with the police, who may not be as forgiving (or even law-abiding) as authorities back home. Not to mention having to deal with potentially nefarious people who are providing those drugs — and their own alternative motives.\nOn a similar note, if you’re partial to late nights out partying until pre-dawn hours, be careful assuming that unfamiliar destinations will be as forgiving as back home.\nMany generally safe destinations (especially ones filled with tourists) become far less secure late at night – and if you’re stumbling around intoxicated, you’re far less aware of your surroundings – and a VERY easy target for all kinds of bad stuff."],
            ['title' => 'Trust Your Instincts!', 'description' => "This one is easily overlooked – and incredibly important.\nYou are a walking surveillance network. Your body sees and hears more things than you could ever process into coherent thought. Let’s call it your “spidey sense” — the ability to sense danger."],
            ['title' => 'Travel Safety For Women vs. Men', 'description' => "All the tips on traveling safely above are equally important for both men and women. I don’t think the ability to travel safely should be focused on gender.\nUnfortunately women are victims of violence everywhere, including here in the United States & Canada. Traveling doesn’t necessarily increase that threat, it simply changes the location.\nWomen worried about being assaulted or harassed might prefer to visit a local street bazaar or nightclub in a group rather than alone. Especially if it’s a common problem for the area.\nI know some women who feel safer carrying a safety whistle and rubber door stop when they travel solo too.\nHowever men also have specific safety concerns they need to watch out for, related to their egos. Like getting goaded into a physical fight that isn’t necessary. Or being scammed by a beautiful woman.\nTravel safety is really about staying street smart, prepared for the unexpected, and minimizing your exposure to risky situations in a new and unfamiliar country."],
            ['title' => 'A Few Words About Risk…', 'description' => "If you want to travel, you cannot avoid risk. There is no way to be 100% safe from any threat, in any part of life. Risk is an integral part of adventure too.\nThis means when you hit the road, you’re bound to get scammed sooner or later, or find yourself in unexpectedly challenging circumstances. It happens to all of us.\nRisk is unavoidable – but it can be managed, so you can stay safer.\nHow do most people hear about events in other countries? It’s usually through the news. This is a big problem, because the media is biased – but not the way politicians would like you to believe.\nThe media reports on unusual events (most often negative ones). Things get featured in the news because they rarely happen. That’s the definition of “newsworthy”.\nIf the news was truly representative of what’s happening in the world, 99.9% of each report would sound like: \“Today in Namib-istan, absolutely nothing dangerous happened, and everyone had a perfectly normal day – yet again.\”"]
        ];

        return $this->render('discover/safety.html.twig',  [
            'subTitle' => 'Safety',
            'safetyTips' => $safetyTips,
            'searchForm' => $this->getSearchForm()->createView()
        ]);
    }

    /**
     * @Route(path="discover/policy", name="discover_policy")
     */
    public function policy()
    {
        return $this->render('discover/policy.html.twig',  [
            'subTitle' => 'Policy',
            'searchForm' => $this->getSearchForm()->createView()
        ]);
    }

    /**
     * @Route(path="discover/about", name="discover_about")
     */
    public function about()
    {
        return $this->render('discover/about.html.twig',  [
            'subTitle' => 'About',
            'searchForm' => $this->getSearchForm()->createView()
        ]);
    }

    /**
     * @Route(path="discover/contact", name="discover_contact")
     *
     * @param Request $request
     * @param ContactUsFormGenerator $contactUsFormGenerator
     *
     * @return Response
     */
    public function contact(Request $request, ContactUsFormGenerator $contactUsFormGenerator, EntityManagerInterface $entityManager)
    {
        $contactForm = $contactUsFormGenerator->generateForm()
            ->setAction($this->generateUrl('discover_contact'))
            ->setMethod(Request::METHOD_POST)
            ->getForm();

        $contactForm->handleRequest($request);

        if($contactForm->isSubmitted() && $contactForm->isValid()) {
            /** @var ContactMessage $contactMessage */
            $contactMessage = $contactForm->getData();

            $entityManager->persist($contactMessage);
            $entityManager->flush();

            $messageSent = true;
        }

        return $this->render('discover/contact.html.twig',  [
            'subTitle' => 'Contact',
            'searchForm' => $this->getSearchForm()->createView(),
            'contactForm' => $contactForm->createView(),
            'messageSent' => $messageSent ?? false
        ]);
    }
}