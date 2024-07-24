export default function UserCard({
  user,
  totalLoans,
  latestBookTitle,
  translations,
}) {
  return (
    <div className="bg-white shadow-lg rounded-xl p-8 mb-8">
      <div className="flex items-center mb-6">
        <div className="bg-blue-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-semibold mr-4">
          {user.name.charAt(0)}
        </div>
        <div>
          <h2 className="text-2xl font-bold text-gray-800">{user.name}</h2>
          <p className="text-gray-600">{user.email}</p>
        </div>
      </div>
      <div className="border-t border-gray-200 pt-6">
        <h3 className="text-xl font-semibold mb-4 text-gray-700">
          {translations.stats}
        </h3>
        <div className="grid grid-cols-2 gap-4">
          <div className="bg-gray-100 rounded-lg p-4">
            <p className="text-sm text-gray-500 mb-1">{translations.last}</p>
            <p className="font-medium text-gray-800">
              {latestBookTitle || 'N/A'}
            </p>
          </div>
          <div className="bg-gray-100 rounded-lg p-4">
            <p className="text-sm text-gray-500 mb-1">{translations.total}</p>
            <p className="font-medium text-gray-800">{totalLoans}</p>
          </div>
        </div>
      </div>
    </div>
  );
}
